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
            :schedule="dateSchedule"
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
        'pages',
        'page',
        'date',
        'dateSchedule'
    ],
    components: {
        Calendar,
        Schedules
    },
    methods: {
        onSetDate(date) {
            this.$emit('set-date', date);
        },
        onOpenSchedule(date) {
            this.$emit('open-schedule', date);
        },
        onBook(interval) {
            this.$emit('book', interval);
        }
    }
};
</script>