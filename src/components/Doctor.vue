<template>
    <div>
        <Calendar
            v-if="page === pages.CALENDAR"
            :date="date"
            v-on:set-date="onSetDate"
            v-on:choose-date="onOpenSchedule" />
        <Schedules
            v-if="page === pages.SCHEDULE"
            :date="date"
            :schedule="schedule"
            v-on:previous-page="$emit('previous-page', page)"
            v-on:book="onBook" />
    </div>
</template>

<script>
import Calendar from './Calendar.vue';
import Schedules from './Schedules.vue';

export default {
    name: 'Doctor',
    props: [
        'doctor',
        'page',
        'date'
    ],
    data() {
        return {
            schedule: []
        }
    },
    components: {
        Calendar,
        Schedules
    },
    created() {
        this.pages = {
            CALENDAR: 'calendar',
            SCHEDULE: 'schedule'
        }
    },
    methods: {
        onSetDate(date) {
            this.$emit('set-date', date);
        },
        async onOpenSchedule(date) {
            this.onSetDate(date);

            const doctorSchedule = await this.getDoctorsSchedule(date);
            if (doctorSchedule.length) {
                this.schedule = doctorSchedule;
                this.$emit('set-page', this.pages.SCHEDULE);
            }
        },
        async getDoctorsSchedule(date) {
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
                this.schedule = await this.getDoctorsSchedule(this.date);
            }
        }
    }
};
</script>