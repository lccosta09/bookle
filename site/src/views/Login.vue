<template>
    <div>
        <Loading :loading="loading" />
        <div v-if="!loading">
            <FlashMessage
                :visible="loginErrorMessage"
                :type="'danger'">
                {{ loginErrorMessage }}
            </FlashMessage>

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
    </div>
</template>

<script>
import Loading from '../components/Loading.vue';
import FlashMessage from '../components/FlashMessage.vue';

export default {
    name: 'Login',
    components: {
        Loading,
        FlashMessage
    },
    data() {
        return {
            loading: false,
            email: '',
            password: '',
            loginErrorMessage: ''
        }
    },
    async mounted() {
    },
    methods: {
        async onSubmit(event) {
            this.loading = true;

            event.preventDefault();

            await this.$store.dispatch('user/login', {
                email: this.email,
                password: this.password
            });

            this.email = '';
            this.password = '';
            this.loading = false;

            if (this.$store.state.user.loggedUser.token) {
                this.$router.push('doctors');
                return;
            }

            this.loginErrorMessage = this.$store.state.user.loginErrorMessage;
        }
    }
}
</script>

<style scoped>
</style>