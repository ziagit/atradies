/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from 'vue-router';
import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';

/* import 'vue-material-design-icons/styles.css'; */

require('./bootstrap');
require('./store/subscriber')

window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(VueMaterial)

//bootstrpa vue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
/* 
import Vue2TouchEvents from 'vue2-touch-events'
 
Vue.use(Vue2TouchEvents) */
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('pagination', require('laravel-vue-pagination'));

import store from "./store";

export const bus = new Vue();
Vue.component('app', require('./components/App.vue').default);

Vue.material.locale.dateFormat = 'dd/MM/yyyy'
 
import router from './routes.js'
import Admin from './components/backend/Admin';
import Home from './components/frontend/Home';
import axios from 'axios';

//axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.baseURL = 'http://31.220.48.103/api/';
//some time when I push to server api still points to localhost, this problem solved by runing 'npm run prod' and then push to server and change .env to production too in server, 
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    const app = new Vue({
        el: '#app',
        router,
        store,
        components: {
            Home,
            Admin
        }
    });
})


