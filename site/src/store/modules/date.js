import axios from 'axios'

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
            await axios.get('http://bookle-api.docker:1212/date.php')
                .then(response => {
                    commit('setTime', parseInt(response.data.date))
                });
        }
    }
};

export default date;