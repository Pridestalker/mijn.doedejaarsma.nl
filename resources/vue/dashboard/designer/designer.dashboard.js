import Vue from 'vue';
import router from './router';
import Dashboard from './Dashboard';

window.addEventListener('load', () => {
    new Vue({router, render: h => h(Dashboard)}).$mount('#profile-dashboard');
})
