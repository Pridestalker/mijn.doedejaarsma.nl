import VueRouter from 'vue-router';
import Vue from 'vue';
import NotFoundComponent from './views/NotFoundComponent'
import DateAdministration from './pages/DateAdministration'
import AdminHome from './pages/AdminHome'
import AdminProducts from './pages/AdminProducts'
import AdminProduct from './pages/AdminProduct'


Vue.use(VueRouter);

const routes = [
    { path: '/', name: 'home', component: AdminHome },
    { path: '/admin', name: 'administration', component: DateAdministration },
    { path: '/products', name: 'products', component: AdminProducts },
    { path: '/products/:id', name: 'product', component: AdminProduct, props: { default: true, parent: 'products'} },
    { path: '*', name: 'not_found', component: NotFoundComponent }
];

const router = new VueRouter({
    routes,
});

export default router;
