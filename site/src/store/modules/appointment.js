import service from '../../service';

const appointment = {
    namespaced: true,
    state() {
        return {
            appointments: {},
            lastAppointment: {
                scheduleId: 0,
                userId: 0
            },
            appointmentErrorMessage: ''
        }
    },
    mutations: {
        setLastAppointment(state, payload) {
            state.lastAppointment = payload;
        },
        setAppointmentErrorMessage(state, payload) {
            state.appointmentErrorMessage = payload;
        }
    },
    actions: {
        async book({commit}, payload) {
            await service().post('book.php', {
                    scheduleId: payload.scheduleId,
                    userId: payload.userId
                })
                .then(response => {
                    commit('setLastAppointment', response.data);
                    commit('setAppointmentErrorMessage', '');
                })
                .catch(async error => {
                    commit('setLastAppointment', {
                        scheduleId: 0,
                        userId: 0
                    });
                    commit('setAppointmentErrorMessage', error.response.data.message);
                });
        }
    }
};

export default appointment;