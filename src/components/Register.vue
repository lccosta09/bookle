<template>
  <div>
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
            console.log(this.$store.state.count);
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
    margin: 40px 0 0;
}
ul {
    list-style-type: none;
    padding: 0;
}
li {
    display: inline-block;
    margin: 0 10px;
}
a {
    color: #42b983;
}
</style>
