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
                    ],
                    1606269600000: [
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
                    1606356000000: [
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
                    ],
                    1606788000000: [
                        {
                            start: '11:30',
                            end: '12:00',
                            appointmentsLimit: 1
                        },
                        {
                            start: '13:00',
                            end: '14:30',
                            appointmentsLimit: 1
                        },
                        {
                            start: '15:30',
                            end: '16:00',
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
            const today = new Date();

            const selectedDate = new Date(payload.date.year, payload.date.month, payload.date.day);
            let entries = Object.entries(schedules).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
            if (!entries) {
                return [];
            }

            let [, doctorSchedules] = entries;
            entries = Object.entries(doctorSchedules).find(([timestamp,]) => selectedDate.getTime() === parseInt(timestamp) && selectedDate.getTime() >= today.getTime());
            if (!entries) {
                return [];
            }

            let [, dateSchedules] = entries;

            return dateSchedules;
        },
        async getByDoctorAndMonth({state}, payload) {
            const schedules = JSON.parse(JSON.stringify(state.schedules));

            const selectedDate = new Date(payload.date.year, payload.date.month, payload.date.day);
            let entries = Object.entries(schedules).find(([doctorId,]) => payload.doctor.id === parseInt(doctorId));
            if (!entries) {
                return [];
            }

            let [, doctorSchedules] = entries;
            entries = Object.entries(doctorSchedules).filter(([timestamp,]) => {
                const date = new Date(parseInt(timestamp));
                return selectedDate.getMonth() === date.getMonth() && selectedDate.getFullYear() === date.getFullYear();
            });

            if (!entries) {
                return [];
            }

            return Object.fromEntries(entries);
        }
    }
};

export default schedule;