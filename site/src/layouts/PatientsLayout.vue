<template>
    <div>
        <PatientsNavBar />
        <div class="container">
            <router-view />
        </div>
    </div>
</template>

<script>
import PatientsNavBar from '../components/PatientsNavBar.vue';

export default {
    name: 'App',
    components: {
        PatientsNavBar,
    }
}
</script>

<style>
</style>