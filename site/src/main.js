import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

import './assets/styles/styles.css';
import './assets/styles/custom.css';

createApp(App)
    .use(router)
    .use(store)
    .mount('#app');

router.beforeEach(async (to, from, next) => {
    if (!store.state.user.loggedUser.token && to.name !== 'login') {
        await store.dispatch('user/refreshToken', {}, {root: true});
        if (store.state.user.loggedUser.token) {
            next();
        }

        next({
            path: 'login'
        });
        return;
    }

    next();
});