<template>
    <div>
        <div v-if="loginError" class="alert alert-dismissible alert-danger">
            {{ loginError }}
        </div>

        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-6">
                    <h1>Bem vindo!</h1>
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
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            loginError: ''
        }
    },
    methods: {
        async onSubmit(event) {
            event.preventDefault();

            const login = await this.$store.dispatch({
                type: 'user/login',
                user: {
                    email: this.email,
                    password: this.password
                }
            });

            if (login) {
                this.$router.push('doctors');
                return;
            }

            this.loginError = 'Usuário e/ou senha inválidos tente novamente';
        }
    }
}
</script>

<style scoped>
</style>