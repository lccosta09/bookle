<template>
    <div>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" :class="{'toggled': toggled}" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <div v-for="(item, itemIndex) in menu" :key="`item-${itemIndex}`">
                <div v-if="item.text" class="sidebar-heading">{{ item.text }}</div>

                <li v-for="(subItem0, subItem0Index) in item.items" :key="`sub-item-${subItem0Index}`" class="nav-item">
                    <a class="nav-link" :class="{collapsed: subItem0.collapsed}" href="#" :data-toggle="subItem0.items && 'collapse'"  aria-expanded="!subItem0.collapsed && 'false'" v-on:click="showSubItems(subItem0.text)">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>{{ subItem0.text }}</span>
                    </a>

                    <div id="collapseTwo" class="collapse" :class="{show: !subItem0.collapsed}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div v-for="(subItem1, subItem1Index) in subItem0.items" :key="`sub-item-${subItem1Index}`" class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">{{ subItem1.text }}</h6>
                            <div v-for="(subItem2, subItem2Index) in subItem1.items" :key="`sub-item-${subItem2Index}`">
                                <a class="collapse-item" href="buttons.html">{{ subItem2.text }}</a>
                            </div>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider">
            </div>

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" v-on:click="$emit('toggled')"></button>
            </div>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'SideBar',
    props: {
        toggled: {
            default() {
                return false;
            }
        }
    },
    data() {
        return {
            menu: [
                {
                    items: [
                        {
                            text: "Dashboard"
                        }
                    ]
                },
                {
                    text: "Interface",
                    items: [
                        {
                            text: "Components",
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
                            text: "Charts"
                        },
                        {
                            text: "Tables"
                        }
                    ]
                }
            ]
        }
    },
    methods: {
        showSubItems(path) {
            const menu = JSON.parse(JSON.stringify(this.menu));
            Object.values(menu).forEach((item, itemIndex) => {
                Object.values(item.items).forEach((subItem0, subItem0Index) => {
                    if (this.menu[itemIndex].items[subItem0Index].text !== path || !this.menu[itemIndex].items[subItem0Index].items) {
                        this.menu[itemIndex].items[subItem0Index].collapsed = true;
                        return;
                    }

                    this.menu[itemIndex].items[subItem0Index].collapsed = !this.menu[itemIndex].items[subItem0Index].collapsed;
                });
            });
        }
    }
}
</script>

<style scoped>
    .nav-link {
        cursor: pointer;
    }
</style>