import Vue from 'vue';
import store from './store/product.store';
import router from './router';
import App from './App';

window.addEventListener('load', () => {
    new Vue({ store, router, render: h => h(App) }).$mount('#product-app');
})
