<template>
    <div>
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-6">
                    <h1>Registre-se</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="bs-component">
                    <form v-on:submit="onSubmit">
                        <div class="form-group">
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E-mail" v-model="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha" v-model="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Register',
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault();

            this.$store.dispatch({
                type: 'user/add',
                user: {
                    'email': this.email,
                    'password': this.password 
                }
            });
            console.log(this.$store.state.user.user);
        }
    }
}
</script>

<style scoped>
</style>
