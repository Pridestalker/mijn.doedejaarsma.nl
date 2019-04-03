<template>
    <div>
        <filter-component></filter-component>
        <div class="d-table w-100">
            <table-header-component></table-header-component>
            <table-row-component v-for="product in products" :key="product.id" :product="product"></table-row-component>
        </div>
    </div>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import FilterComponent from './FilterComponent';
import TableRowComponent from './TableRowComponent';
import TableHeaderComponent from './TableHeaderComponent';

@Component( {
    components: { TableRowComponent, TableHeaderComponent, FilterComponent },
} )
export default class TableComponent extends Vue {
    products = [];

    async fetchData() {
        this.products = (await this.$http.get('/api/v1/products')).data.data;
    }

    mounted() {
        this.fetchData();
    }
}
</script>

<style scoped>

</style>
