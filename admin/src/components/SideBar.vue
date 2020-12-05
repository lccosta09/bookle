<template>
    <div>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" :class="{'toggled': !toggled}" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <SideBarMenu :items="menuItems" v-on:toggle-menu-items-collapse="$emit('toggle-menu-items-collapse', $event)" />

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" v-on:click="$emit('toggled')"></button>
            </div>
        </ul>
    </div>
</template>

<script>
import SideBarMenu from './SideBarMenu';

export default {
    name: 'SideBar',
    components: {
        SideBarMenu
    },
    props: {
        toggled: {
            default() {
                return true;
            }
        },
        menuItems: {
            default() {
                return [];
            }
        }
    }
}
</script>

<style scoped>
</style>