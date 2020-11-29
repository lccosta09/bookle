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
        async getAll({commit, rootState, dispatch}) {
            axios.defaults.withCredentials = true;
            await axios.get('http://bookle-api.docker:1212/doctors.php', {
                    headers: {
                        'Authorization': `${'Bearer'} ${rootState.user.loggedUser.token}`
                    }
                })
                .then(response => {
                    commit('setDoctors', response.data)
                })
                .catch(async error => {
                    if (error.response.status === 401) {
                        await dispatch('user/refreshToken', {
                                originalAction: 'doctor/getAll',
                                originalPayload: {
                                    type: 'doctor/getAll'
                                }
                            }, {root: true});
                    }
                });
        }
    }
};

export default doctor;