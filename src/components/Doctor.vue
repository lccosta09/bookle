<template>
    <div>
        <p>{{ doctor.description }}</p>
        <Calendar v-if="page === pages.CALENDAR" v-on:choose-date="openSchedule" />
        <Schedules v-if="page === pages.SCHEDULE" :schedules="schedules" />
    </div>
</template>

<script>
import Calendar from './Calendar.vue';
import Schedules from './Schedules.vue';

export default {
    name: 'Doctor',
    props: [
        'doctor'
    ],
    data() {
        return {
            page: '',
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

        this.page = this.pages.CALENDAR;
    },
    methods: {
        openSchedule(date) {
            this.$store.dispatch({
                type: 'schedule/getByDoctorAndDate',
                doctor: this.doctor,
                date
            }).then(response => {
                this.schedule = response;
                this.page = this.pages.SCHEDULE;
            });
        }
    }
};
</script>