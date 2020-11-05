import { createStore } from 'vuex';

const store = createStore({
    state () {
        return {
            count: 1
        }
    },
    mutations: {
        increment (state, payload) {
            return state.count += payload.amount;
        }
    },
    actions: {
        increment (context, payload) {
            context.commit('increment', payload);
        }
    }
});

export default store;