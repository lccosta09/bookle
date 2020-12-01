import service from '../../service';

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
        async getAll({commit, dispatch}) {
            await service().get('doctors.php')
                .then(response => {
                    commit('setDoctors', response.data)
                })
                .catch(async error => {
                    if (error.response.status === 401) {
                        await dispatch('user/refreshToken', {}, {root: true});
                        await dispatch('doctor/getAll', {}, {root: true});
                    }
                });
        }
    }
};

export default doctor;