<template>
    <div>
        <p>{{ doctor.name }}</p>
    </div>
</template>

<script>
export default {
    name: 'Doctor',
    props: [
        'doctor'
    ]
};
</script>

<style scoped>
</style>
