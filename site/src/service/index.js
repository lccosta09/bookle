import axios from 'axios';
import store from '../store';
import router from '../router';

export default ({ requiresAuth = true } = {}) => {
    let options = {
        baseURL: 'http://bookle-api.docker:1212/',
        defaults: {
            withCredentials : true
        },
        headers: {}
    };

    if (requiresAuth) {
        options.headers.Authorization = `Bearer ${store.state.user.loggedUser.token}`;
    }

    const instance = axios.create(options);

    instance.interceptors.response.use(response => {
        return response;
    }, error => {
        const { dispatch } = store;

        if (error.response.status === 401) {
            return dispatch('user/refreshToken').then(() => {
                if (store.state.user.loggedUser.token) {
                    error.config.headers.Authorization = `Bearer ${store.state.user.loggedUser.token}`;
                    return instance.request(error.config);
                }

                router.push('login');
            });
        }

        return Promise.reject(error);
    });

    return instance;
}