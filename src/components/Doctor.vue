<template>
    <div>
        <p>{{ doctor.description }}</p>
        <Calendar v-if="step === steps.CALENDAR" v-on:choose-date="openSchedule" />
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
        this.steps = {
            CALENDAR: 'calendar',
            SCHEDULE: 'schedule'
        }

        this.step = this.steps.CALENDAR;
    },
    methods: {
        openSchedule(date) {
            this.$store.dispatch({
                type: 'schedule/getByDoctorAndDate',
                doctor: this.doctor,
                date
            }).then(response => {
                this.schedule  = response;
                this.step = this.SCHEDULE;
            });
        }
    }
};
</script>