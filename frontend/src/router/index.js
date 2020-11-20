import { createWebHistory, createRouter } from 'vue-router';
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import Doctors from '../components/Doctors.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/doctors',
        name: 'doctors',
        component: Doctors
    }
];

const router = createRouter({
    mode: 'history',
    history: createWebHistory(),
    routes
});

export default router;