<template>
    <section>
        <pre>
            {{ productModule.product }}
        </pre>
    </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { productModule, ProductModule } from '../../../store/product.module'

@Component
export default class ProductDebug extends Vue {
    productModule: ProductModule = productModule;
}
</script>
