const appointment = {
    namespaced: true,
    state() {
        return {
            appointments: {}
        }
    },
    mutations: {
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
        async add({state}, payload) {
            const date = new Date(payload.date.year, payload.date.month, payload.date.day);
            const time = date.getTime();
            state.appointments[payload.scheduleId] = state.appointments[payload.scheduleId] ?? {};
            state.appointments[payload.scheduleId][time] = state.appointments[payload.scheduleId][time] ?? [];
            state.appointments[payload.scheduleId][time].push(payload.interval);
            return true;
        }
    }
};

export default appointment;