import axios from 'axios';

const user = {
    namespaced: true,
    state() {
        return {
            users: [],
            loggedUser: {
                email: '',
                password: ''
            },
            loginErrorMessage: ''
        }
    },
    mutations: {
        setLoggedUser(state, payload) {
            state.loggedUser = payload;
        },
        setLoginErrorMessage(state, payload) {
            state.loginErrorMessage = payload;
        }
    },
    actions: {
        async login({commit}, payload) {
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