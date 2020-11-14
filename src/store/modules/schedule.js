const schedule = {
    namespaced: true,
    state() {
        return {
            schedules: {
                1: {
                    10: {
                        16: [
                            {
                                start: '09:30',
                                end: '10:00'
                            },
                            {
                                start: '14:00',
                                end: '14:30'
                            },
                            {
                                start: '15:00',
                                end: '15:30'
                            }
                        ]
                    }
                }
            }
        }
    },
    mutations: {
    },
    actions: {
    }
};

export default schedule;