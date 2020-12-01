<template>
    <div>
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand">Bookle</router-link>
                <button class="navbar-toggler" :class="{'collapsed': collapsed}" type="button" v-on:click="() => this.toogleCollapse()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" :class="{'collapse': collapsed, 'show': !collapsed}" id="navbarResponsive">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link :to="{ name: 'doctors' }" class="nav-link">Médicos</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PatientsNavBar',
    data() {
        return {
            collapsed: true
        }
    },
    methods: {
        toogleCollapse() {
            this.collapsed = !this.collapsed; 
        }
    }
}
</script>

<style>
</style>