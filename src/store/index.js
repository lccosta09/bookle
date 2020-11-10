import { createStore } from 'vuex';
import user from './modules/user.js';
import doctor from './modules/doctor.js';

const store = createStore({
    modules: {
        user,
        doctor
    }
});

export default store;