const appointment = {
    namespaced: true,
    state() {
        return {
            appointments: {
                1: {
                    1605492000000: [
                        {
                            start: '09:30',
                            end: '10:00',
                        },
                    ],
                    1605578400000: [
                        {
                            start: '11:00',
                            end: '11:30'
                        },
                        {
                            start: '13:30',
                            end: '14:00'
                        }
                    ]
                }
            }
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
        }
    }
};

export default appointment;