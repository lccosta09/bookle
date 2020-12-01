import { createWebHistory, createRouter } from 'vue-router';
import Home from '../components/Home.vue';
import PatientsLayout from '../layouts/PatientsLayout.vue';
import SiteLayout from '../layouts/SiteLayout.vue';
import Login from '../components/Login.vue';
import Doctors from '../components/Doctors.vue';
import store from '../store';

const routes = [
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
    },
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