<template>
    <div>
        <p>{{ doctor.description }}</p>
        <Calendar v-on:choose-date="dateChosen" />
    </div>
</template>

<script>
import Calendar from './Calendar.vue';

export default {
    name: 'Doctor',
    props: [
        'doctor'
    ],
    components: {
        Calendar
    },
    methods: {
        dateChosen(date) {
            console.log(date);
        }
    }
};
</script>