<template>
    <div>
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand">Bookle</router-link>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link :to="{ name: 'register' }" class="nav-link">Registre-se</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: 'App'
}
</script>

<style>
</style>