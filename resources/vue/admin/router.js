import VueRouter from 'vue-router';
import Vue from 'vue';
import OverviewModule from './modules/overview.module';
import SingleModule from './modules/single.module';
import NewOverviewModule from './modules/Overview.new.module'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'index',
        component: NewOverviewModule
    },
    {
        path: '/old',
        name: 'index_old',
        component: OverviewModule
    },
    {
        path: '/single/:id',
        name: 'single',
        component: SingleModule
    }
];

const router = new VueRouter({
    routes,
});

export default router;
