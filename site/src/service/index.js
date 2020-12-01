import axios from 'axios';
import store from '../store';

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

    return instance;
}