import axios from 'axios';

const doctor = {
    namespaced: true,
    state() {
        return {
            doctors: []
        }
    },
    mutations: {
        add(state, payload) {
            state.doctors = [...state.doctors, payload.doctor];
        },
        setDoctors(state, payload) {
            state.doctors = payload;
        }
    },
    actions: {
        add(context, payload) {
            context.commit('add', payload);
        },
        async getAll({commit, rootState}) {
            axios.defaults.withCredentials = true;
            await axios.get('http://bookle-api.docker:1212/doctors.php', {
                    headers: {
                        'Authorization': `${'Bearer'} ${rootState.user.loggedUser.token}`
                    }
                })
                .then(response => {
                    commit('setDoctors', response.data)
                });
        }
    }
};

export default doctor;