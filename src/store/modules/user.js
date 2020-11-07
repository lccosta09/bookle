const user = {
    namespaced: true,
    state() {
        return {
            users: []
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
        }
    }
};

export default user;