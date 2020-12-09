<template>
    <div>
        <div v-for="(item, itemIndex) in items" :key="`item-${itemIndex}`">
            <div v-if="item.text" class="sidebar-heading">{{ item.text }}</div>

            <li v-for="(subItem0, subItem0Index) in item.items" :key="`sub-item-${subItem0Index}`" class="nav-item">
                <a class="nav-link" :class="{collapsed: subItem0.collapsed}" href="#" :data-toggle="subItem0.items && 'collapse'" :aria-expanded="subItem0.collapsed ? 'false' : 'true'" v-on:click="$emit('toggle-menu-items-collapse', subItem0.text)">
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
    </div>
</template>

<script>
export default {
    name: 'SideBarMenu',
    props: {
        items: {
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