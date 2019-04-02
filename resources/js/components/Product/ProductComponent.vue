<template>
    <article>
        <section :data-name="product.name" data-title="Naam:">Naam: {{ product.name }}</section>
        
        <section :data-name="product.description" data-title="Omschrijving:" v-if="product.description">Omschrijving: {{ product.description }}</section>
        
        <section :data-name="product.soort" data-title="Soort:">Soort: {{ product.soort }}</section>
        
        <section :data-name="product.format" data-title="Formaat:" v-if="product.format">Formaat: {{ product.format }}</section>
        
        <section :data-name="product.deadline" data-title="Deadline:">Deadline: {{ computedDeadline }}</section>
        
        <section :data-name="product.status" data-title="Status:">Status: {{ product.status }}</section>
        
        <product-options-component :options="JSON.parse(product.options)" v-if="product.options"></product-options-component>
        
        <section :data-name="product.factuur" data-title="Factuur:" v-if="product.factuur">Factuur: {{ product.factuur }}</section>
        
        <section v-if="product.attachment">
            <a :href="'/products/' + product.id + '/image'">
                Voorbeeld
            </a>
        </section>
        
        <aside v-if="product.hours">
            Gemaakte uren: {{ formattedHours }}
        </aside>
    </article>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import ProductOptionsComponent from './ProductOptionsComponent'
import { format } from 'date-fns';
import { nl } from 'date-fns/locale'

@Component({
    props: {
        id: {
            type: Number,
            default: undefined,
        }
    },
    components: {
        ProductOptionsComponent
    },
    name: "ProductComponent"
})
export default class ProductComponent extends Vue {
    error = false;
    
    product = {};
    
    mounted() {
        if (!this.id) {
            this.error = false;
            return;
        }
        
        this.fetchData();
    }
    
    fetchData() {
        this.$emit('product-loading');
        this
            .$http
            .get(`/api/v1/products/${this.id}`)
            .then((res) => {
                this.$emit('product-loaded');
                this.product = res.data.data;
            })
            .catch((err)=> {
                const id = this.id
                this.error = false;
                this.$emit('product-error', { err, id });
            })
    }
    
    get computedDeadline() {
        if (!this.product.deadline) {
            return '';
        }
        
        return format(new Date(this.product.deadline), 'cccc dd MMMM YYYY', { awareOfUnicodeTokens: true, locale: nl })
    }
    
    get formattedHours() {
        if (!this.product) {
            return '';
        }
        if (!this.product.hours) {
            return '';
        }
        let total = this.product.hours.total.toString().split('.')
        let decimal = (this.product.hours.total - Math.floor(this.product.hours.total)).toPrecision(2) * 100;
        if (!decimal) {
            return Math.floor(this.product.hours.total)
        }
        return `${Math.floor(this.product.hours.total)}:${(decimal/100 * 60).toPrecision(2)}`
    }
}
</script>
