<template>
    <div id="page-top">
        <div id="wrapper">
            <SideBar
                :menuItems="sideBarMenuItems"
                :toggled="sideBarToggled"
                v-on:toggle-menu-items-collapse="toggleMenuItemsCollapse"
                v-on:toggled="toggleSideBar"
                v-on:logout="logout" />
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <TopBar
                        :userDropdownToggled="userDropdownToggled"
                        v-on:sidebar-toggled="toggleSideBar"
                        v-on:user-dropdown-toggled="toggleUserDropdown"
                        v-on:logout="logout" />

                    <div class="container-fluid">
                        <Loading :loading="loading" />
                        <router-view />
                    </div>
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright © Your Website 2020</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import SideBar from './SideBar.vue';
import TopBar from './TopBar.vue';
import Loading from './Loading.vue';

export default {
    name: 'App',
    components: {
        Loading,
        SideBar,
        TopBar
    },
    data() {
        return {
            loading: false,
            sideBarToggled: true,
            userDropdownToggled: false,
            sideBarMenuItems: [
                {
                    items: [
                        {
                            text: "Dashboard",
                            icon: "fa-tachometer-alt"
                        }
                    ]
                },
                {
                    text: "",
                    items: [
                        {
                            text: "Components",
                            icon: "fa-cog",
                            collapsed: true,
                            items: [
                                {
                                    text: "",
                                    items: [
                                        {
                                            text: 'Buttons'
                                        },
                                        {
                                            text: 'Cards'
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            text: "Utilities",
                            icon: "fa-wrench",
                            collapsed: true,
                            items: [
                                {
                                    text: "",
                                    items: [
                                        {
                                            text: 'Colors'
                                        },
                                        {
                                            text: 'Borders'
                                        },
                                        {
                                            text: 'Animations'
                                        },
                                        {
                                            text: 'Others'
                                        }
                                    ]
                                }
                            ]
                        }
                    ]
                },
                {
                    text: "",
                    items: [
                        {
                            text: "Pages",
                            icon: "fa-folder",
                            collapsed: true,
                            items: [
                                {
                                    text: "",
                                    items: [
                                        {
                                            text: "Login"
                                        },
                                        {
                                            text: "Register"
                                        },
                                        {
                                            text: "Forgot Password"
                                        }
                                    ]
                                },
                                {
                                    text: "",
                                    items: [
                                        {
                                            text: "404 Page"
                                        },
                                        {
                                            text: "Blank Page"
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            text: "Charts",
                            icon: "fa-chart-area"
                        },
                        {
                            text: "Tables",
                            icon: "fa-table"
                        }
                    ]
                }
            ]
        };
    },
    mounted() {
        window.addEventListener('resize', this.resized);
        document.addEventListener('click', this.close);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.resized);
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
        toggleMenuItemsCollapse(path) {
            const menu = JSON.parse(JSON.stringify(this.sideBarMenuItems));
            Object.values(menu).forEach((item, itemIndex) => {
                Object.values(item.items).forEach((subItem0, subItem0Index) => {
                    if (this.sideBarMenuItems[itemIndex].items[subItem0Index].text !== path || !this.sideBarMenuItems[itemIndex].items[subItem0Index].items && !this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsed) {
                        setTimeout(() => {
                            this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsed = true;
                            this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsing = false;
                        }, 60);
                        return;
                    }

                    this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsing = true;
                    setTimeout(() => {
                        this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsed = !this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsed;
                        this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsing = false;
                    }, 60);
                });
            });
        },
        collapseAllMenuItems() {
            const menu = JSON.parse(JSON.stringify(this.sideBarMenuItems));
            Object.values(menu).forEach((item, itemIndex) => {
                Object.values(item.items).forEach((subItem0, subItem0Index) => {
                    this.sideBarMenuItems[itemIndex].items[subItem0Index].collapsed = true;
                });
            });
        },
        toggleSideBar() {
            this.sideBarToggled = !this.sideBarToggled;
            if (!this.sideBarToggled) {
                this.collapseAllMenuItems();
            }
        },
        toggleUserDropdown() {
            this.userDropdownToggled = !this.userDropdownToggled;
        },
        close(event) {
            if (!document.getElementById('userDropdown').contains(event.target)) {
                this.userDropdownToggled = false;
            }
        },
        resized() {
            if (window.innerWidth < 500 && this.sideBarToggled) {
                this.toggleSideBar();
            }
        }
    }
}
</script>

<style>
</style>