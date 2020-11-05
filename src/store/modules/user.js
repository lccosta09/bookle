const user = {
    namespaced: true,
    state() {
        return {
            users: {}
        }
    },
    mutations: {
        add(state, payload) {
            state.user = payload.user;
        }
    },
    actions: {
        add(context, payload) {
            context.commit('add', payload);
        }
    }
};

export default user;