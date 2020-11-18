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
                :page="modalPage"
                :date="date"
                :dateSchedule="doctorDateSchedule"
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

        return {
            isModalOpen: false,
            doctor: {
                name: '',
            },
            modalPage: 'calendar',
            date: {
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate()
            },
            doctorDateSchedule: []
        }
    },
    created() {
        this.pages = {
            CALENDAR: 'calendar',
            SCHEDULE: 'schedule'
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
        onSetModalPage(page) {
            this.modalPage = page;
        },
        onSetDate(date) {
            this.date = date;
        },
        onPreviosPage(page) {
            const pages = {
                [this.pages.SCHEDULE]: this.pages.CALENDAR
            }

            this.modalPage = pages[page];
        },
        async onOpenSchedule(date) {
            this.onSetDate(date);

            const doctorDateSchedule = await this.getDoctorDateSchedule(date);
            if (doctorDateSchedule.length) {
                this.doctorDateSchedule = doctorDateSchedule;
                this.onSetModalPage(this.pages.SCHEDULE);
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
