<template>
    <div id="page-top">
        <Loading :loading="loading" />
        <div id="wrapper">
            <NavBar v-on:logout="logout" />
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <NavBarTop v-on:logout="logout" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import NavBarTop from '../components/NavBarTop.vue';
import Loading from '../components/Loading.vue';

export default {
    name: 'App',
    components: {
        Loading,
        NavBar,
        NavBarTop
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