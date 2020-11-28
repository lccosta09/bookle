import axios from 'axios';

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
        async book({commit, rootState}, payload) {
            await axios.post('http://bookle-api.docker:1212/book.php', {
                    scheduleId: payload.scheduleId,
                    userId: payload.userId
                },
                {
                    headers: {
                        'Authorization': `${'Bearer'} ${rootState.user.loggedUser.token}`
                    }
                })
                .then(response => {
                    commit('setLastAppointment', response.data);
                    commit('setAppointmentErrorMessage', '');
                })
                .catch(error => {
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