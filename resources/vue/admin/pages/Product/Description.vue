<template>
    <section class="section">
        <p class="content" v-if="productModule.product.description">
            {{ productModule.product.description }}
        </p>
    
        <b-button v-if="$route.meta.editing" icon-left="pen">Omschrijving</b-button>
    </section>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator'
    import { productModule, ProductModule } from '../../../store/product.module'
    
    @Component
    export default class ProductDescription extends Vue {
        productModule: ProductModule = productModule;
    }
</script>
