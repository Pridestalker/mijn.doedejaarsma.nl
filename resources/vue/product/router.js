import VueRouter from 'vue-router';
import Vue from 'vue';
import OverviewModule from './modules/overview.module';
import SingleModule from './modules/single.module';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'index',
        component: OverviewModule,
    },
    {
        path: '/single/:id',
        name: 'single',
        component: SingleModule,
    }
]

const router = new VueRouter({
    routes,
});

export default router;
