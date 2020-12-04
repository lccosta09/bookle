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
                    <a class="nav-link" :class="{collapsed: subItem0.collapsed}" href="#" :data-toggle="subItem0.items && 'collapse'"  aria-expanded="!subItem0.collapsed && 'false'" v-on:click="$emit('toogle-menu-items-collapse', subItem0.text)">
                        <i class="fas fa-fw" :class="{[subItem0.icon]: true}"></i>
                        <span>{{ subItem0.text }}</span>
                    </a>

                    <div id="collapseTwo" class="collapse" :class="{show: !subItem0.collapsed && subItem0.items}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div v-for="(subItem1, subItem1Index) in subItem0.items" :key="`sub-item-${subItem1Index}`">
                                <h6 class="collapse-header">{{ subItem1.text }}</h6>
                                <div v-for="(subItem2, subItem2Index) in subItem1.items" :key="`sub-item-${subItem2Index}`">
                                    <a class="collapse-item" href="buttons.html">{{ subItem2.text }}</a>
                                </div>
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
        },
        menu: {
            default() {
                return [];
            }
        }
    }
}
</script>

<style scoped>
    .nav-link {
        cursor: pointer;
    }
</style>