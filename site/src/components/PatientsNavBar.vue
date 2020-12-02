<template>
    <div>
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand">Bookle</router-link>
                <button class="navbar-toggler" :class="{'collapsed': collapsed}" type="button" v-on:click="() => this.collapsed = !this.collapsed">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" :class="{'collapse': collapsed, 'show': !collapsed}" id="navbarResponsive">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link :to="{ name: 'doctors' }" class="nav-link">Médicos</router-link>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link" v-on:click="$emit('logout')">Sair</span>
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
    }
}
</script>

<style scoped>
    .nav-link {
        cursor: pointer;
    }
</style>