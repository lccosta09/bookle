import { createWebHistory, createRouter } from 'vue-router';
import PatientsLayout from '../layouts/PatientsLayout.vue';
import SiteLayout from '../layouts/SiteLayout.vue';
import Login from '../views/Login.vue';
import Doctors from '../views/Doctors.vue';
import Home from '../views/Home.vue';
import store from '../store';

const routes = [
    {
        path: '/login',
        component: SiteLayout,
        children: [
            {
                path: '',
                name: 'login',
                component: Login
            }
        ]
    },
    {
        path: '/doctors',
        component: PatientsLayout,
        children: [
            {
                path: '',
                name: 'doctors',
                component: Doctors
            }
        ]
    },
    {
        path: '/',
        component: SiteLayout,
        children: [
            {
                path: '',
                name: 'home',
                component: Home
            }
        ]
    }
];

const router = createRouter({
    mode: 'history',
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    if (to.name === 'login') {
        await store.dispatch('user/refreshToken');
        if (store.state.user.loggedUser.token) {
            next({
                path: 'doctors'
            });
            return;
        }
    }

    if (!store.state.user.loggedUser.token && to.name !== 'login') {
        await store.dispatch('user/refreshToken', {}, {root: true});
        if (store.state.user.loggedUser.token) {
            next();
            return;
        }

        next({
            path: 'login'
        });
        return;
    }

    next();
});

export default router;