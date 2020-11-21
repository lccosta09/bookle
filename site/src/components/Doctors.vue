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
                :bookedInterval="bookedInterval"
                :bookingError="bookingError"
                v-on:open-schedule="onOpenSchedule"
                v-on:set-date="onSetDate"
                v-on:previous-page="onPreviosPage"
                v-on:book="onBook"
                v-on:clear-booking-error="() => this.bookingError = ''" />
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
            bookedInterval: {
                start: '',
                end: ''
            },
            bookingError: ''
        }
    },
    async mounted() {
        await this.$store.dispatch('date/getTime');

        const date = new Date(this.$store.state.date.time);
        this.today = {
            year: date.getFullYear(),
            month: date.getMonth(),
            day: date.getDate()
        };

        this.date = {...this.today};
    },
    methods: {
        async openModal(doctor) {
            await this.$store.dispatch('date/getTime');

            const date = new Date(this.$store.state.date.time);
            this.today = {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            };

            this.date = {...this.today};

            this.isModalOpen = true;
            this.doctor = doctor;
            this.doctorMonthSchedule = await this.getDoctorMonthSchedule(this.date);
            this.modalPage = 'calendar';
        },
        async onSetDate(date) {
            if (this.date.year !== date.year ||this.date.month !== date.month) {
                this.doctorMonthSchedule = await this.getDoctorMonthSchedule(date);
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

            this.bookingError = '';
            this.date = date;

            const doctorDateSchedule = await this.getDoctorDateSchedule(date);
            if (doctorDateSchedule.length) {
                this.doctorDateSchedule = doctorDateSchedule;
                this.modalPage = this.modalPages.SCHEDULE;
            }
        },
        async getDoctorMonthSchedule(date) {
            let schedule = await this.$store.dispatch({
                type: 'schedule/getByDoctorAndMonth',
                doctorId: this.doctor.id,
                date
            });

            const appointments = await this.$store.dispatch({
                type: 'appointment/getByDoctorAndMonth',
                doctorId: this.doctor.id,
                date
            });

            Object.entries(schedule).forEach(([timestamp,]) => {
                const doctorSchedule = schedule[timestamp].filter((scheduleInterval) => {
                    if (!appointments[timestamp]) {
                        return true;
                    }

                    const scheduleAppointments = appointments[timestamp].filter((appointmentInterval) => {
                        return scheduleInterval.start === appointmentInterval.start && scheduleInterval.end === appointmentInterval.end;
                    });

                    return scheduleAppointments.length < scheduleInterval.appointmentsLimit;
                });

                schedule[timestamp] = doctorSchedule;
            });

            return schedule;
        },
        async getDoctorDateSchedule(date) {
            const schedule = await this.$store.dispatch({
                type: 'schedule/getByDoctorAndDate',
                doctorId: this.doctor.id,
                date
            });

            const appointments = await this.$store.dispatch({
                type: 'appointment/getByDoctorAndDate',
                doctorId: this.doctor.id,
                date
            });

            let doctorSchedule = schedule.filter((scheduleInterval) => {
                const scheduleAppointments = appointments.filter((appointmentInterval) => {
                    return scheduleInterval.start === appointmentInterval.start && scheduleInterval.end === appointmentInterval.end;
                });

                return scheduleAppointments.length < scheduleInterval.appointmentsLimit;
            });

            return doctorSchedule;
        },
        async onBook(interval) {
            const userAppointments = await this.$store.dispatch({
                type: 'appointment/getByUserAndDoctor',
                doctorId: this.doctor.id,
                userId: this.$store.state.user.loggedUser.id
            });

            if (userAppointments.length) {
                this.bookingError = 'Você já possui uma consulta agendada com este médico';
                return;
            }

            const added = await this.$store.dispatch({
                type: 'appointment/add',
                doctorId: this.doctor.id,
                date: this.date,
                interval: {
                    start: interval.start,
                    end: interval.end,
                    userId: this.$store.state.user.loggedUser.id
                }
            });

            if (!added) {
                this.bookingError = 'Não foi possível realizar o agendamento tente novamente mais tarde';
                return;
            }

            this.doctorDateSchedule = await this.getDoctorDateSchedule(this.date);
            this.doctorMonthSchedule = await this.getDoctorMonthSchedule(this.date);
            this.bookedInterval = interval;
            this.modalPage = this.modalPages.BOOKED_MESSAGE;
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