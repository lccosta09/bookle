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
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>{{ subItem0.text }}</span>
                    </a>

                    <hr class="sidebar-divider">
                </li>
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
                        }
                    ]
                }
            ]
        }
    }
}
</script>

<style scoped>
    .nav-link {
        cursor: pointer;
    }
</style>