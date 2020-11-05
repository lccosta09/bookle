<template>
    <div>
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-6">
                    <h1>Registre-se</h1>
                </div>
            </div>
        </div>
        <button v-on:click="increment">Incrementar</button>
    </div>
</template>

<script>
export default {
    name: 'Register',
    methods: {
        increment() {
            this.$store.dispatch({
                type: 'increment',
                amount: 20
            });
            console.log(this.$store.state.moduleA.count);
        }
    }
}
</script>

<style scoped>
</style>
