import VueRouter from 'vue-router';
import Vue from 'vue';
import OverviewModule from './modules/Overview.module'
import NotFoundComponent from './views/NotFoundComponent'


Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'administration',
        component: OverviewModule
    },
    {
        path: '*',
        name: 'not_found',
        component: NotFoundComponent
    }
];

const router = new VueRouter({
    routes,
});

export default router;
