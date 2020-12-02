import { createStore } from 'vuex';
import user from './modules/user.js';
import date from './modules/date.js';

const store = createStore({
    modules: {
        user,
        date
    }
});

export default store;