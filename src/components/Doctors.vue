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
        <Modal :title="doctor.name" :isOpen="isModalOpen" v-on:close="onCloseModal">
            <Doctor
                :doctor="doctor"
                :pages="modalPages"
                :page="modalPage"
                :date="date"
                :dateSchedule="doctorDateSchedule"
                :bookedInterval="bookedInterval"
                v-on:open-schedule="onOpenSchedule"
                v-on:book="onBook"
                v-on:set-date="onSetDate"
                v-on:previous-page="onPreviosPage" />
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
        const date = new Date();
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
            date: {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            },
            doctorDateSchedule: [],
            bookedInterval: {
                start: '',
                end: ''
            }
        }
    },
    methods: {
        openModal(doctor) {
            this.isModalOpen = true;
            this.doctor = doctor;
        },
        onCloseModal() {
            const date = new Date();

            this.isModalOpen = false;
            this.modalPage = 'calendar';
            this.date = {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            };
        },
        onSetDate(date) {
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
            this.onSetDate(date);

            const doctorDateSchedule = await this.getDoctorDateSchedule(date);
            if (doctorDateSchedule.length) {
                this.doctorDateSchedule = doctorDateSchedule;
                this.modalPage = this.modalPages.SCHEDULE;
            }
        },
        async getDoctorDateSchedule(date) {
            const schedule = await this.$store.dispatch({
                type: 'schedule/getByDoctorAndDate',
                doctor: this.doctor,
                date
            });

            const appointments = await this.$store.dispatch({
                type: 'appointment/getByDoctorAndDate',
                doctor: this.doctor,
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
            const added = await this.$store.dispatch({
                type: 'appointment/add',
                doctor: this.doctor,
                date: this.date,
                interval: {
                    start: interval.start,
                    end: interval.end
                }
            });

            if (added) {
                this.doctorDateSchedule = await this.getDoctorDateSchedule(this.date);
                this.bookedInterval = interval;
                this.modalPage = this.modalPages.BOOKED_MESSAGE;
            }
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