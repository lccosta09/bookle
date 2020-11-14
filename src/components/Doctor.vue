<template>
    <div>
        <p>{{ doctor.description }}</p>
        <Calendar />
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
    }
};
</script>