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

            const selecteDate = new Date(payload.date.year, payload.date.month, payload.date.day);
            let entries = Object.entries(appointments).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
            if (!entries) {
                return [];
            }

            let [, doctorAppointments] = entries;
            entries = Object.entries(doctorAppointments).find(([timestamp,]) => selecteDate.getTime() === parseInt(timestamp));
            if (!entries) {
                return [];
            }

            let [, dateappointments] = entries;

            return dateappointments;
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