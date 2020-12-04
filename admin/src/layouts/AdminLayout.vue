<template>
    <div id="page-top">
        <Loading :loading="loading" />
        <div id="wrapper">
            <SideBar
                :toggled="sideBarToggled"
                v-on:toggled="toggleSideBar"
                v-on:logout="logout" />
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <NavBarTop
                        :userDropdownToggled="userDropdownToggled"
                        v-on:sidebar-toggled="toggleSideBar"
                        v-on:user-dropdown-toggled="toggleUserDropdown"
                        v-on:logout="logout" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SideBar from '../components/SideBar.vue';
import NavBarTop from '../components/NavBarTop.vue';
import Loading from '../components/Loading.vue';

export default {
    name: 'App',
    components: {
        Loading,
        SideBar,
        NavBarTop
    },
    data() {
        return {
            loading: false,
            sideBarToggled: false,
            userDropdownToggled: false
        };
    },
    mounted() {
        document.addEventListener('click', this.close);
    },
    beforeUnmount() {
        document.removeEventListener('click', this.close);
    },
    methods: {
        async logout() {
            this.loading = true;
            await this.$store.dispatch('user/logout');
            this.loading = false;

            if (!this.$store.state.user.logoutErrorMessage) {
                this.$router.push('login');
            }
        },
        toggleSideBar() {
            this.sideBarToggled = !this.sideBarToggled;
        },
        toggleUserDropdown() {
            this.userDropdownToggled = !this.userDropdownToggled;
        },
        close(event) {
            if (!document.getElementById('userDropdown').contains(event.target)) {
                this.userDropdownToggled = false;
            }
        }
    }
}
</script>

<style>
</style>