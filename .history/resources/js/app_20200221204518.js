
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import axios from 'axios';

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

require('./bootstrap');
require('bootstrap-vue');

//axios.defaults.baseURL = 'https://baltiteh.ee/ceres/portal';
// window.axios.defaults.baseURL = window.location.origin;
window.axios.defaults.baseURL = window.location.origin;

window.Vue = require('vue');
window.axios = axios;

Vue.config.productionTip = false;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('calculator-component', require('./components/CalculatorComponent.vue'));
Vue.component('portal-component', require('./components/PortalComponent.vue'));
Vue.component('insurance-component', require('./components/InsuranceComponent.vue'));
Vue.component('purchase-component', require('./components/Purchase.vue'));

const app = new Vue({
    el: '#transweb'
});
