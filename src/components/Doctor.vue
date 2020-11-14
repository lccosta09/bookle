<template>
    <div>
        <p>{{ doctor.description }}</p>
        <Calendar v-if="step === CALENDAR" v-on:choose-date="showSchedule" />
    </div>
</template>

<script>
import Calendar from './Calendar.vue';

export default {
    name: 'Doctor',
    props: [
        'doctor'
    ],
    data() {
        return {
            step: '',
            schedule: []
        }
    },
    components: {
        Calendar
    },
    created() {
        this.CALENDAR = 'calendar';
        this.SCHEDULE = 'schedule';
        this.step = this.CALENDAR;
    },
    methods: {
        showSchedule(date) {
            // this.step = this.SCHEDULE;
            this.schedule = this.getSchedule(date);
        },
        getSchedule(date) {
            const schedules = JSON.parse(JSON.stringify(this.$store.state.schedule.schedules));

            const selecteDate = new Date(date.year, date.month, date.day);
            let [, doctorSchedules] = Object.entries(schedules).find(([doctorId,]) => this.doctor.id === parseInt(doctorId));
            let [, dateSchedules] = Object.entries(doctorSchedules).find(([timestamp,]) => selecteDate.getTime() === parseInt(timestamp));

            return dateSchedules;
        }
    }
};
</script>