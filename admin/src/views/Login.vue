<template>
    <div>
        <Loading :loading="loading" />
        <div class="container">
            <div v-if="!loading" class="row justify-content-center">
                <FlashMessage
                    :visible="loginErrorMessage"
                    :type="'danger'">
                    {{ loginErrorMessage }}
                </FlashMessage>
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" v-on:submit="onSubmit">
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address..." v-model="email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" placeholder="Password" v-model="password">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                            <hr>
                                            <a href="index.html" class="btn btn-google btn-user btn-block">
                                                <i class="fab fa-google fa-fw"></i> Login with Google
                                            </a>
                                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                                <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                            </a>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="register.html">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                this.$router.push('dashboard');
                return;
            }

            this.loginErrorMessage = this.$store.state.user.loginErrorMessage;
        }
    }
}
</script>

<style scoped>
    .p-5 {
        padding: 2rem !important;
    }

    .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl {
        padding-left: 0;
        padding-right: 0;
    }

    .container, .container-lg, .container-md, .container-sm, .container-xl {
        max-width: 600px;
    }

    @media (max-width: 576px) {
        .p-5 {
            padding: 1.2rem !important;
        }
    }
</style>