import { createWebHistory, createRouter } from 'vue-router';
import AdminLayout from '../layouts/AdminLayout.vue';
import LoginLayout from '../layouts/LoginLayout.vue';
import Login from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';
import store from '../store';

const routes = [
    {
        path: '/login',
        component: LoginLayout,
        children: [
            {
                path: '',
                name: 'login',
                component: Login
            }
        ]
    },
    {
        path: '/dashboard',
        component: AdminLayout,
        children: [
            {
                path: '',
                name: 'dashboard',
                component: Dashboard
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
                path: 'dashboard'
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