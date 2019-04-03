<template>
    <aside class="d-table-row table-header">
        <span class="d-table-cell font-weight-bold">#</span>
        <span class="d-table-cell font-weight-bold">Naam</span>
        <span class="d-table-cell font-weight-bold">Uren</span>
        <span class="d-table-cell font-weight-bold">Opdrachtegever</span>
    </aside>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component
export default class TableHeaderComponent extends Vue {}
</script>
