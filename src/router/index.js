import { createWebHistory, createRouter } from 'vue-router';
import Home from '../components/Home.vue';
import Register from '../components/Register.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    }
];

const router = createRouter({
    mode: 'history',
    history: createWebHistory(),
    routes
});

export default router;