<template>
    <main>
        <router-link to="/">Terug naar overzicht</router-link>
        <router-view></router-view>
    </main>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import VueRouter from 'vue-router';
import TableComponent from '../../components/Admin/tt/TableComponent';
import SingleTrackView from './SingleTrackView';


Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: "home",
        component: TableComponent,
    },
    {
        path: '/single/:id',
        name: 'single',
        component: SingleTrackView,
    }
]

const router = new VueRouter({
    routes
});

const RoutedApp = Vue.extend({router});

@Component
export default class AdminTrackView extends RoutedApp {}
</script>

