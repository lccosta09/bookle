<template>
    <div>
        <div v-if="page !== pages.CALENDAR" class="back" v-on:click="$emit('previous-page', page)">
            <span class="icon">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
            </span>Voltar
        </div>

        <Calendar
            v-if="page === pages.CALENDAR"
            :date="date"
            v-on:set-date="$emit('set-date', $event)"
            v-on:choose-date="$emit('open-schedule', $event)" />
        <Schedules
            v-if="page === pages.SCHEDULE"
            :date="date"
            :schedule="dateSchedule"
            v-on:book="$emit('book', $event)" />
        <BookedMessage
            v-if="page === pages.BOOKED_MESSAGE"
            :date="date"
            :doctor="doctor"
            :interval="bookedInterval" />
    </div>
</template>

<script>
import Calendar from './Calendar.vue';
import Schedules from './Schedules.vue';
import BookedMessage from './BookedMessage.vue';

export default {
    name: 'Doctor',
    props: [
        'doctor',
        'pages',
        'page',
        'date',
        'dateSchedule',
        'bookedInterval'
    ],
    components: {
        Calendar,
        Schedules,
        BookedMessage
    }
};
</script>

<style scoped>
    .back {
        height: 1.5rem;
        line-height: 1.5rem;
        cursor: pointer;
        margin-bottom: 15px;
        display: inline-block;
    }
</style>