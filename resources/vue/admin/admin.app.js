import Vue from 'vue';
import Component from 'vue-class-component';
import store from '../store/store';
import router from './router';
import Admin from './Admin';
import Buefy from 'buefy';

Component.registerHooks([
    'beforeRouteEnter',
    'beforeRouteLeave',
    'beforeRouteUpdate' // for vue-router 2.2+
])

Vue.use(Buefy);

window.addEventListener('load', () => {
    new Vue({store, router, render: h => h(Admin)}).$mount('#admin-app');
})
