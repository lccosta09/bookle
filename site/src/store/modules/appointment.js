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
        async getByDoctorAndDate({state}, payload) {
            const appointments = JSON.parse(JSON.stringify(state.appointments));

            const selectedDate = new Date(payload.date.year, payload.date.month, payload.date.day);
            let entries = Object.entries(appointments).find(([doctorId,]) => payload.doctorId === parseInt(doctorId));
            if (!entries) {
                return [];
            }

            let [, doctorAppointments] = entries;
            entries = Object.entries(doctorAppointments).find(([timestamp,]) => selectedDate.getTime() === parseInt(timestamp));
            if (!entries) {
                return [];
            }

            let [, dateAppointments] = entries;

            return dateAppointments;
        },
        async getByDoctorAndMonth({state}, payload) {
            const appointments = JSON.parse(JSON.stringify(state.appointments));

            const selectedDate = new Date(payload.date.year, payload.date.month, payload.date.day);
            let entries = Object.entries(appointments).find(([doctorId,]) => payload.doctorId === parseInt(doctorId));
            if (!entries) {
                return [];
            }

            let [, doctorAppointments] = entries;
            entries = Object.entries(doctorAppointments).filter(([timestamp,]) => {
                const date = new Date(parseInt(timestamp));
                return selectedDate.getMonth() === date.getMonth() && selectedDate.getFullYear() === date.getFullYear();
            });

            if (!entries) {
                return [];
            }

            return Object.fromEntries(entries);
        },
        async getByUserAndDoctor({state}, payload) {
            const appointments = JSON.parse(JSON.stringify(state.appointments));

            let userAppointments = [];

            Object.entries(appointments).forEach(([doctorId, doctorAppointments]) => {
                if (parseInt(doctorId) !== payload.doctorId) {
                    return;
                }

                Object.entries(doctorAppointments).forEach(([timestamp, appointmens]) => {
                    const date = new Date(timestamp);
                    const today = new Date();

                    if (date.getTime() < today.today) {
                        return;
                    }

                    userAppointments = [...userAppointments, ...appointmens.filter((appointment) => {
                        return parseInt(appointment.userId) === payload.userId;
                    })];
                });
            });

            return userAppointments;
        },
        async book({commit}, payload) {
            await axios.post('http://bookle-api.docker:1212/book.php', {
                    scheduleId: payload.scheduleId,
                    userId: payload.userId
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