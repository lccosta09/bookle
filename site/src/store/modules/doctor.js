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
        async getAll({commit}) {
            await service().get('doctors.php')
                .then(response => {
                    commit('setDoctors', response.data)
                });
        }
    }
};

export default doctor;