<template>
    <section class="section content" v-if="productModule.product.options">
        <ul>
            <li v-for="(option, key) in JSON.parse(productModule.product.options)" :key="key" v-if="option">
                {{key}}: {{ option }}
            </li>
        </ul>
    </section>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import { productModule, ProductModule } from '../../../store/product.module'
    
    @Component
    export default class ProductOptions extends Vue {
        productModule: ProductModule = productModule;
    }
</script>
