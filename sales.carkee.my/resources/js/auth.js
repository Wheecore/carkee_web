import axios from 'axios';

export function login(credentials) {
    return axios.post('/api/login', credentials);
}

export function logout() {
    return axios.post('/api/logout');
}

export function checkAuth() {
    return axios.get('/api/user');
}
