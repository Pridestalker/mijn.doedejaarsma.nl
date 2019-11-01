<template>
    <section class="content">
        <h1 >
            {{ productModule.product.name }}
        </h1>
        <p>
            <small v-if="productModule.product.owner.id">
                <a :href="'mailto:' + productModule.product.owner.email">
                    {{ productModule.product.owner.name }}
                </a> van {{ productModule.product.owner.team[0].name}}
                     op {{ formattedDate(productModule.product.created_at) }}
            </small>
        </p>
        <product-header-tabs></product-header-tabs>
    </section>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator'
    import { productModule, ProductModule } from '../../../store/product.module'
    import { format } from "date-fns"
    import { nl } from "date-fns/locale"
    import ProductHeaderTabs from './Header/Tabs.vue';
    
    @Component({
        components: { ProductHeaderTabs }
    })
    export default class ProductHeader extends Vue {
        productModule: ProductModule = productModule;

        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl })
        }
    }
</script>
