<template>
    <div>
        <PatientsNavBar v-on:logout="logout" />
        <Loading :loading="loading" />
        <div v-show="!loading">
            <div class="container">
                <router-view v-on:loading="(loading) => this.loading = loading" />
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../components/Loading.vue';
import PatientsNavBar from '../components/PatientsNavBar.vue';

export default {
    name: 'App',
    components: {
        Loading,
        PatientsNavBar
    },
    data() {
        return {
            loading: false
        };
    },
    methods: {
        async logout() {
            this.loading = true;
            await this.$store.dispatch('user/logout');
            this.loading = false;

            if (!this.$store.state.user.logoutErrorMessage) {
                this.$router.push('login');
            }
        }
    }
}
</script>

<style>
</style>