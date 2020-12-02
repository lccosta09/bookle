<template>
    <div>
        <SiteNavBar />
        <div class="container">
            <router-view />
        </div>
    </div>
</template>

<script>
import SiteNavBar from '../components/SiteNavBar.vue';

export default {
    name: 'LoginLayout',
    components: {
        SiteNavBar,
    }
}
</script>

<style>
</style>