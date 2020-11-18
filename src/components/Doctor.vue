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
            v-on:previous-page="$emit('previous-page', page)" />
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

            this.schedule = await this.$store.dispatch({
                type: 'schedule/getByDoctorAndDate',
                doctor: this.doctor,
                date
            });

            if (!this.schedule.length) {
                return;
            }

            this.$emit('set-page', this.pages.SCHEDULE);
        }
    }
};
</script>