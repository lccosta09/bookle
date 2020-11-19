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
            let entries = Object.entries(appointments).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
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
            let entries = Object.entries(appointments).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
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
        async add({state}, payload) {
            const date = new Date(payload.date.year, payload.date.month, payload.date.day);
            const time = date.getTime();

            state.appointments[payload.doctor.id] = state.appointments[payload.doctor.id] ?? {};
            state.appointments[payload.doctor.id][time] = state.appointments[payload.doctor.id][time] ?? [];
            state.appointments[payload.doctor.id][time].push(payload.interval);
            return true;
        }
    }
};

export default appointment;