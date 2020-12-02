<template>
    <div>
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand">Bookle</router-link>
                <button class="navbar-toggler" :class="{'collapsed': collapsed}" type="button" v-on:click="() => this.collapsed = !this.collapsed">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SiteNavBar',
    data() {
        return {
            collapsed: true
        }
    }
}
</script>

<style>
</style>