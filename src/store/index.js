import { createStore } from 'vuex';
import moduleA from './modules/moduleA.js';

const store = createStore({
    modules: {
        moduleA
    }
});

export default store;