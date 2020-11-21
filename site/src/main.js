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

router.beforeEach((to, from, next) => {
    if (!store.state.user.loggedUser.email && to.name !== 'login') {
        next({
            path: 'login'
        });
        return;
    }

    next();
});