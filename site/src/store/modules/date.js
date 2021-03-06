import service from '../../service';

const date = {
    namespaced: true,
    state() {
        return {
            time: 0
        }
    },
    mutations: {
        setTime(state, time) {
            state.time = time;
        }
    },
    actions: {
        async getTime({commit}) {
            await service({
                    requiresAuth: false
                })
                .get('date.php')
                .then(response => {
                    commit('setTime', parseInt(response.data.date))
                });
        }
    }
};

export default date;