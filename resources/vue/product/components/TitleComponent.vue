<template>
    <h1 class="is-highlight">
        <slot></slot>
    </h1>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component
export default class TitleComponent extends Vue {}
</script>

<style scoped>
    .is-highlight {
        background: -webkit-linear-gradient(rgb(10, 10, 180), rgb(20, 189, 179));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
