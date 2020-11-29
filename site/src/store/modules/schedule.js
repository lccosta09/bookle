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
        async getByDoctorAndDate({commit, rootState, dispatch}, payload) {
            let month = payload.date.month + 1;
            const day = payload.date.day.toString().length < 2 ? '0'.repeat(2 - payload.date.day.toString().length) + payload.date.day : payload.date.day.toString();
            month = month.toString().length < 2 ? '0'.repeat(2 - month.toString().length) + month : month.toString();

            axios.defaults.withCredentials = true;
            await axios.get('http://bookle-api.docker:1212/schedules.php', {
                    headers: {
                        'Authorization': `${'Bearer'} ${rootState.user.loggedUser.token}`
                    },
                    params: {
                        doctorId: payload.doctorId,
                        year: payload.date.year,
                        month,
                        date: `${payload.date.year}-${month}-${day}`
                    }
                })
                .then(response => {
                    commit('setSchedule', response.data)
                })
                .catch(async error => {
                    if (error.response.status === 401) {
                        await dispatch('user/refreshToken', {}, {root: true});
                        await dispatch('schedule/getByDoctorAndDate', {}, {root: true});
                    }
                });
        },
        async getByDoctorAndMonth({commit, rootState, dispatch}, payload) {
            let month = payload.date.month + 1;
            month = month.toString().length < 2 ? '0'.repeat(2 - month.toString().length) + month : month.toString();

            axios.defaults.withCredentials = true;
            await axios.get('http://bookle-api.docker:1212/schedules.php', {
                    headers: {
                        'Authorization': `${'Bearer'} ${rootState.user.loggedUser.token}`
                    },
                    params: {
                        doctorId: payload.doctorId,
                        year: payload.date.year,
                        month
                    }
                })
                .then(response => {
                    commit('setSchedule', response.data)
                })
                .catch(async error => {
                    if (error.response.status === 401) {
                        await dispatch('user/refreshToken', {}, {root: true});
                        await dispatch('schedule/getByDoctorAndMonth', payload, {root: true});
                    }
                });
        }
    }
};

export default schedule;