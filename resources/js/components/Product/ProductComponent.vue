<template>
    <article>
        <section :data-name="product.name" data-title="Naam:">Naam: {{ product.name }}</section>
        
        <section :data-name="product.description" data-title="Omschrijving:" v-if="product.description">Omschrijving: {{ product.description }}</section>
        
        <section :data-name="product.soort" data-title="Soort:">Soort: {{ product.soort }}</section>
        
        <section :data-name="product.format" data-title="Formaat:" v-if="product.format">Formaat: {{ product.format }}</section>
        
        <section :data-name="product.deadline" data-title="Deadline:">Deadline: {{ product.deadline }}</section>
        
        <section :data-name="product.status" data-title="Status:">Status: {{ product.status }}</section>
        
        <product-options-component :options="JSON.parse(product.options)" v-if="product.options"></product-options-component>
        
        <section :data-name="product.factuur" data-title="Factuur:" v-if="product.factuur">Factuur: {{ product.factuur }}</section>
        
        <section v-if="product.attachment">
            <a :href="'/products/' + product.id + '/image'">
                Voorbeeld
            </a>
        </section>
    </article>
</template>

<script>
    import ProductOptionsComponent from './ProductOptionsComponent'
    export default {
        name: "ProductComponent",
        components: { ProductOptionsComponent },
        data() {
            return {
                error: false,
                product: {},
            }
        },
        props: {
            id: {
                type: Number,
                default: undefined,
            }
        },
        methods: {
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
            },
        },
        mounted() {
            if (!this.id) {
                this.error = false
                return;
            }
            
            this.fetchData();
        }
    }
</script>

<style scoped>

</style>
