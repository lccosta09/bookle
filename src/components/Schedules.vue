<template>
    <div>
        <div v-for="(inteval, index) in schedule" :key="`inteval-${index}`">
            <div>{{ inteval.start }}</div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Schedules',
    props: [
        'schedule'
    ],
};
</script>