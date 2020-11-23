import axios from 'axios';

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
            await axios.get('http://bookle-api.docker:1212/schedules.php', {
                    params: {
                        doctorId: payload.doctorId,
                        year: payload.date.year,
                        month: payload.date.month + 1,
                        date: `${payload.date.year}-${payload.date.month + 1}-${payload.date.day}`
                    }
                })
                .then(response => {
                    commit('setSchedule', response.data)
                });
        },
        async getByDoctorAndMonth({commit}, payload) {
            await axios.get('http://bookle-api.docker:1212/schedules.php', {
                    params: {
                        doctorId: payload.doctorId,
                        year: payload.date.year,
                        month: payload.date.month + 1
                    }
                })
                .then(response => {
                    commit('setSchedule', response.data)
                });
        }
    }
};

export default schedule;