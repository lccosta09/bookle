import service from '../../service';

const schedule = {
    namespaced: true,
    state() {
        return {
            schedules: {}
        }
    },
    mutations: {
        setSchedule(state, payload) {
            state.schedules = payload;
        }
    },
    actions: {
        async getByDoctorAndDate({commit}, payload) {
            let month = payload.date.month + 1;
            const day = payload.date.day.toString().length < 2 ? '0'.repeat(2 - payload.date.day.toString().length) + payload.date.day : payload.date.day.toString();
            month = month.toString().length < 2 ? '0'.repeat(2 - month.toString().length) + month : month.toString();

            await service().get('schedules.php', {
                    params: {
                        doctorId: payload.doctorId,
                        year: payload.date.year,
                        month,
                        date: `${payload.date.year}-${month}-${day}`
                    }
                })
                .then(response => {
                    commit('setSchedule', response.data)
                });
        },
        async getByDoctorAndMonth({commit}, payload) {
            let month = payload.date.month + 1;
            month = month.toString().length < 2 ? '0'.repeat(2 - month.toString().length) + month : month.toString();

            await service().get('schedules.php', {
                    params: {
                        doctorId: payload.doctorId,
                        year: payload.date.year,
                        month
                    }
                })
                .then(response => {
                    commit('setSchedule', response.data)
                });
        }
    }
};

export default schedule;