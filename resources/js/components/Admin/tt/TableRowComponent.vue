<template>
    <section class="d-table-row">
        <span class="d-table-cell">
            <router-link :to="{ name: 'single', params: { id: product.id} }">
                {{ product.id }}
            </router-link>
        </span>
        <span class="d-table-cell">
            {{ product.name }}
        </span>
        <span class="d-table-cell">
            {{ product.hours.total }}
        </span>
        <span class="d-table-cell">
            {{ product.owner.team[0].name }}
        </span>
    </section>
</template>

<script>
import Component from "vue-class-component";
import Vue from "vue";

const TableRowProps = Vue.extend({
    props: {
        product: {
            type: Object,
            default: {},
            required: true
        }
    }
});

@Component
export default class TableRowComponent extends TableRowProps {
    hours = [];
    
    async fetchHours() {
        const params = {
            product: this.product.id
        }
        
        this.hours = (await this.$http.get('/api/v1/hours', { params })).data.data;
    }
}
</script>
