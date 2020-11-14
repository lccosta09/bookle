<template>
    <div>
        <p>{{ doctor.description }}</p>
        <Calendar v-if="page === pages.CALENDAR" v-on:choose-date="openSchedule" />
        <Schedules v-if="page === pages.SCHEDULE" :schedule="schedule" />
    </div>
</template>

<script>
import Calendar from './Calendar.vue';
import Schedules from './Schedules.vue';

export default {
    name: 'Doctor',
    props: [
        'doctor',
        'page'
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
        openSchedule(date) {
            this.$store.dispatch({
                type: 'schedule/getByDoctorAndDate',
                doctor: this.doctor,
                date
            }).then(response => {
                this.schedule = response;
                this.$emit('set-page', this.pages.SCHEDULE);
            });
        }
    }
};
</script>