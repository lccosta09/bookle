import axios from 'axios';

const user = {
    namespaced: true,
    state() {
        return {
            users: [],
            loggedUser: {
                id: 0,
                email: '',
                token: ''
            },
            loginErrorMessage: '',
            logoutErrorMessage: ''
        }
    },
    mutations: {
        setLoggedUser(state, payload) {
            state.loggedUser = {
                id: payload.id,
                email: payload.email,
                token: payload.token
            };
        },
        setLoginErrorMessage(state, payload) {
            state.loginErrorMessage = payload;
        },
        setLogoutErrorMessage(state, payload) {
            state.logoutErrorMessage = payload;
        }
    },
    actions: {
        async login({commit}, payload) {
            axios.defaults.withCredentials = true;
            await axios.post('http://bookle-api.docker:1212/login.php', {
                    email: payload.email,
                    password: payload.password
                })
                .then(response => {
                    commit('setLoggedUser', response.data);
                    commit('setLoginErrorMessage', '');
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        commit('setLoggedUser', {
                            email: '',
                            password: '',
                            token: ''
                        });
                        commit('setLoginErrorMessage', error.response.data.message);
                    }
                });
        },
        async refreshToken({commit}) {
            axios.defaults.withCredentials = true;
            await axios.get('http://bookle-api.docker:1212/refresh_token.php')
                .then(async response => {
                    commit('setLoggedUser', response.data);
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        commit('setLoggedUser', {
                            email: '',
                            password: '',
                            token: ''
                        });
                        commit('setLoginErrorMessage', error.response.data.message);
                    }
                });
        },
        async logout({commit}) {
            axios.defaults.withCredentials = true;
            await axios.get('http://bookle-api.docker:1212/logout.php')
                .then(async () => {
                    commit('setLoggedUser', {
                        email: '',
                        password: '',
                        token: ''
                    });
                    commit('setLogoutErrorMessage', '');
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        commit('setLogoutErrorMessage', error.response.data.message);
                    }
                });
        }
    }
};

export default user;