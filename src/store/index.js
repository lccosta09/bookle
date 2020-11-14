import { createStore } from 'vuex';
import user from './modules/user.js';
import doctor from './modules/doctor.js';
import schedule from './modules/schedule.js';

const store = createStore({
    modules: {
        user,
        doctor,
        schedule
    }
});

export default store;