
window._ = require('lodash');

import Vue from 'vue';

import axios from 'axios';

import Vuex from 'vuex';
window.Vue = Vue;

window.axios = axios;
Vue.use(Vuex);
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
