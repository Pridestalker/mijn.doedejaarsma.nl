import Vue from 'vue';
import store from '../store/store';
import router from './router';
import App from './App';

new Vue({ store, router, render: h => h(App) }).$mount('#product-app');
