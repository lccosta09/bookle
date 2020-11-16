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
                            patientsLimit: 2
                        },
                        {
                            start: '14:00',
                            end: '14:30',
                            patientsLimit: 2
                        },
                        {
                            start: '15:00',
                            end: '15:30',
                            patientsLimit: 2
                        }
                    ],
                    1605578400000: [
                        {
                            start: '10:30',
                            end: '11:00',
                            patientsLimit: 2
                        },
                        {
                            start: '11:00',
                            end: '11:30',
                            patientsLimit: 2
                        },
                        {
                            start: '13:30',
                            end: '14:00',
                            patientsLimit: 2
                        }
                    ]
                }
            }
        }
    },
    mutations: {
    },
    actions: {
        getByDoctorAndDate({state}, payload) {
            return new Promise((resolve) => {
                const schedules = JSON.parse(JSON.stringify(state.schedules));

                const selecteDate = new Date(payload.date.year, payload.date.month, payload.date.day);
                let entries = Object.entries(schedules).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
                if (!entries) {
                    return resolve([]);
                }

                let [, doctorSchedules] = entries;
                entries = Object.entries(doctorSchedules).find(([timestamp,]) => selecteDate.getTime() === parseInt(timestamp));
                if (!entries) {
                    return resolve([]);
                }

                let [, dateSchedules] = entries;

                resolve(dateSchedules);
            });
        }
    }
};

export default schedule;