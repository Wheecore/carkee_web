import $ from 'jquery';
import './bootstrap';

window.$ = window.jQuery = $;

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

import App from './App.vue';
import routes from './router';

axios.defaults.APP_URL = process.env.MIX_APP_URL;
axios.defaults.APP_NAME = process.env.APP_NAME;

const router = createRouter({
    history: createWebHistory(process.env.APP_URL),
    routes
});

const app = createApp(App);

app.use(router).mount('#app');
