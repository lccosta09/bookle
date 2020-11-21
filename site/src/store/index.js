import { createStore } from 'vuex';
import user from './modules/user.js';
import doctor from './modules/doctor.js';
import schedule from './modules/schedule.js';
import appointment from './modules/appointment.js';
import date from './modules/date.js';

const store = createStore({
    modules: {
        user,
        doctor,
        schedule,
        appointment,
        date
    }
});

export default store;