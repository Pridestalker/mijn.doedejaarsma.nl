<template>
    <main>
        <router-view></router-view>
    </main>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component
export default class App extends Vue {}
</script>
