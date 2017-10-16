
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Vue Directives
 */

Vue.directive('mdl', {
    bind: function(el) {
        componentHandler.upgradeElement(el);
    }
});

/**
 * Helper
 */

window.Event = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tictactoe', require('./components/Tictactoe.vue'));
Vue.component('progress-bar', require('./components/ProgressBar.vue'));

const app = new Vue({
    el: '#app'
});
