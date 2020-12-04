<template>
    <div id="page-top">
        <Loading :loading="loading" />
        <div id="wrapper">
            <SideBar
                :menu="sideBarMenu"
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SideBar from '../components/SideBar.vue';
import TopBar from '../components/TopBar.vue';
import Loading from '../components/Loading.vue';

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
            sideBarMenu: [
                {
                    items: [
                        {
                            text: "Dashboard",
                            icon: "fa-tachometer-alt"
                        }
                    ]
                },
                {
                    text: "Interface",
                    items: [
                        {
                            text: "Components",
                            icon: "fa-cog",
                            collapsed: true,
                            items: [
                                {
                                    text: "Custom Components",
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
                                    text: "Custom Utilities",
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
                    text: "Addons",
                    items: [
                        {
                            text: "Pages",
                            icon: "fa-folder",
                            collapsed: true,
                            items: [
                                {
                                    text: "Login Screens",
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
                                    text: "Other Pages",
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
        toggleMenuItemsCollapse(path) {
            const menu = JSON.parse(JSON.stringify(this.sideBarMenu));
            Object.values(menu).forEach((item, itemIndex) => {
                Object.values(item.items).forEach((subItem0, subItem0Index) => {
                    if (this.sideBarMenu[itemIndex].items[subItem0Index].text !== path || !this.sideBarMenu[itemIndex].items[subItem0Index].items) {
                        this.sideBarMenu[itemIndex].items[subItem0Index].collapsed = true;
                        return;
                    }

                    this.sideBarMenu[itemIndex].items[subItem0Index].collapsed = !this.sideBarMenu[itemIndex].items[subItem0Index].collapsed;
                });
            });
        },
        collapseAllMenuItems() {
            const menu = JSON.parse(JSON.stringify(this.sideBarMenu));
            Object.values(menu).forEach((item, itemIndex) => {
                Object.values(item.items).forEach((subItem0, subItem0Index) => {
                    this.sideBarMenu[itemIndex].items[subItem0Index].collapsed = true;
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
        }
    }
}
</script>

<style>
</style>