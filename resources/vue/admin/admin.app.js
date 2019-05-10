import Vue from 'vue';
import store from './store/admin.store';
import router from './router';
import Admin from './Admin';

window.addEventListener('load', () => {
    new Vue({store, router,render: h => h(Admin)}).$mount('#admin-app');
})
