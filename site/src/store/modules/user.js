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
            loginErrorMessage: ''
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
                    commit('setLoggedUser', {
                        email: '',
                        password: ''
                    });
                    commit('setLoginErrorMessage', error.response.data.message);
                });
        }
    }
};

export default user;