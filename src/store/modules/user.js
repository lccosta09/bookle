const user = {
    namespaced: true,
    state() {
        return {
            users: [
                {
                    id: 1,
                    email: 'correialesp@gmail.com',
                    password: '1234'
                },
                {
                    id: 2,
                    email: 'felipe.oliveira@gmail.com',
                    password: '1234'
                }
            ],
            loggedUser: {
                email: '',
                password: ''
            }
        }
    },
    mutations: {
        add(state, payload) {
            state.users = [...state.users, payload.user];
        }
    },
    actions: {
        add(context, payload) {
            context.commit('add', payload);
        },
        async login({state}, payload) {
            const users = JSON.parse(JSON.stringify(state.users));
            const user = users.find(user => user.email === payload.user.email && user.password === payload.user.password);
            if (user) {
                state.loggedUser = user;
                return true;
            }

            return false;
        }
    }
};

export default user;