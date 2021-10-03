
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('comics', require('./components/Comics.vue'));
Vue.component('radio', require('./components/Radio.vue'));
Vue.component('multiple', require('./components/Multiple.vue'));
Vue.component('textolibre', require('./components/Texto.vue'));

const app = new Vue({
    el: '#app',
    data:{
        menu:0,
        notifications: [],
    },
});
