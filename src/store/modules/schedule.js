const schedule = {
    namespaced: true,
    state() {
        return {
            schedules: {
                1: {
                    1605492000000: [
                        {
                            start: '09:30',
                            end: '10:00',
                            appointmentsLimit: 1
                        },
                        {
                            start: '14:00',
                            end: '14:30',
                            appointmentsLimit: 1
                        },
                        {
                            start: '15:00',
                            end: '15:30',
                            appointmentsLimit: 1
                        }
                    ],
                    1605578400000: [
                        {
                            start: '10:30',
                            end: '11:00',
                            appointmentsLimit: 1
                        },
                        {
                            start: '11:00',
                            end: '11:30',
                            appointmentsLimit: 1
                        },
                        {
                            start: '13:30',
                            end: '14:00',
                            appointmentsLimit: 1
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
            const schedules = JSON.parse(JSON.stringify(state.schedules));

            const selecteDate = new Date(payload.date.year, payload.date.month, payload.date.day);
            let entries = Object.entries(schedules).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
            if (!entries) {
                return [];
            }

            let [, doctorSchedules] = entries;
            entries = Object.entries(doctorSchedules).find(([timestamp,]) => selecteDate.getTime() === parseInt(timestamp));
            if (!entries) {
                return [];
            }

            let [, dateSchedules] = entries;

            return dateSchedules;
        }
    }
};

export default schedule;