import VueRouter from 'vue-router';
import Vue from 'vue';
import ProfileModule from './modules/profile.module';


Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'index',
        component: ProfileModule
    }
];

const router = new VueRouter({
    routes
});

export default router;
