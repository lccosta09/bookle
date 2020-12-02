<template>
    <div>
        <div class="row">
            <div v-for="doctor in this.$store.state.doctor.doctors" :key="doctor.id" class="col-lg-4">
                <div class="bs-component">
                    <div class="card border-primary mb-3 doctor">
                        <div class="card-body">
                            <h4 class="card-title" v-text="doctor.name"></h4>
                            <p class="card-text" v-text="doctor.description"></p>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse">
                            <button type="button" class="btn btn-primary" v-on:click="() => this.openModal(doctor)">Ver agenda</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal
            :title="doctor.name"
            :loadind="loadingModal"
            :isOpen="isModalOpen"
            v-on:close="() => this.isModalOpen = false">
            <Doctor
                :doctor="doctor"
                :pages="modalPages"
                :page="modalPage"
                :today="today"
                :date="date"
                :dateSchedule="doctorDateSchedule"
                :monthSchedule="doctorMonthSchedule"
                :bookedSchedule="bookedSchedule"
                :bookingError="bookingError"
                v-on:open-schedule="onOpenSchedule"
                v-on:set-date="onSetDate"
                v-on:previous-page="onPreviosPage"
                v-on:book="onBook" />
        </Modal>
    </div>
</template>

<script>
import Modal from './Modal.vue';
import Doctor from './Doctor.vue';

export default {
    name: 'Doctors',
    components: {
        Modal,
        Doctor
    },
    data() {
        const modalPages = {
            CALENDAR: 'calendar',
            SCHEDULE: 'schedule',
            BOOKED_MESSAGE: 'booked-message'
        };

        return {
            loadingModal: true,
            isModalOpen: false,
            doctor: {
                name: '',
            },
            modalPages,
            modalPage: modalPages.CALENDAR,
            date: {},
            today: {},
            doctorMonthSchedule: {},
            doctorDateSchedule: [],
            bookedSchedule: {
                start: '',
                end: ''
            },
            bookingError: ''
        }
    },
    async mounted() {
        this.$emit('loadind', true);

        await this.$store.dispatch('date/getTime');

        const date = new Date(this.$store.state.date.time);
        this.today = {
            year: date.getFullYear(),
            month: date.getMonth(),
            day: date.getDate()
        };

        this.date = {...this.today};

        await this.$store.dispatch('doctor/getAll');

        this.$emit('loadind', false);
    },
    methods: {
        async openModal(doctor) {
            this.isModalOpen = true;
            this.loadingModal = true;

            await this.$store.dispatch('date/getTime');

            const date = new Date(this.$store.state.date.time);
            this.today = {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            };

            this.date = {...this.today};

            this.doctor = doctor;
            this.doctorMonthSchedule = await this.getDoctorMonthSchedule(this.date);
            this.modalPage = 'calendar';

            this.loadingModal = false;
        },
        async onSetDate(date) {
            if (this.date.year !== date.year ||this.date.month !== date.month) {
                this.loadingModal = true;
                this.doctorMonthSchedule = await this.getDoctorMonthSchedule(date);
                this.loadingModal = false;
            }

            this.date = date;
        },
        onPreviosPage(page) {
            const pages = {
                [this.modalPages.SCHEDULE]: this.modalPages.CALENDAR,
                [this.modalPages.BOOKED_MESSAGE]: this.modalPages.CALENDAR
            }

            this.modalPage = pages[page];
        },
        async onOpenSchedule(date) {
            if (date.month !== this.date.month || date.year !== this.date.year) {
                return;
            }

            this.loadingModal = true;
            this.bookingError = '';
            this.date = date;

            const doctorDateSchedule = await this.getDoctorDateSchedule(date);
            if (doctorDateSchedule.length) {
                this.doctorDateSchedule = doctorDateSchedule;
                this.modalPage = this.modalPages.SCHEDULE;
            }

            this.loadingModal = false;
        },
        async getDoctorMonthSchedule(date) {
            await this.$store.dispatch('schedule/getByDoctorAndMonth', {
                doctorId: this.doctor.id,
                date
            });

            return this.$store.state.schedule.schedules;
        },
        async getDoctorDateSchedule(date) {
            await this.$store.dispatch('schedule/getByDoctorAndDate', {
                doctorId: this.doctor.id,
                date
            });

            return this.$store.state.schedule.schedules;
        },
        async onBook(schedule) {
            this.loadingModal = true;

            await this.$store.dispatch('appointment/book', {
                userId: this.$store.state.user.loggedUser.id,
                scheduleId: schedule.id
            });

            if (!this.$store.state.appointment.lastAppointment.userId) {
                this.bookingError = this.$store.state.appointment.appointmentErrorMessage;
                this.loadingModal = false;
                return;
            }

            this.doctorDateSchedule = await this.getDoctorDateSchedule(this.date);
            this.doctorMonthSchedule = await this.getDoctorMonthSchedule(this.date);
            this.bookedSchedule = schedule;
            this.modalPage = this.modalPages.BOOKED_MESSAGE;
            this.loadingModal = false;
        }
    }
};
</script>

<style scoped>
    .doctor {
        min-height: 200px;
    }

    .show {
        display: block;
    }
</style>