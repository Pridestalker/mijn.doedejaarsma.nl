<template>
    <main>
        <product-header></product-header>
        <product-deadline></product-deadline>
        <product-description></product-description>
        <product-options></product-options>
        <!-- Product footer -->
        <product-footer></product-footer>
        <!-- Debug only -->
        <product-debug></product-debug>
    </main>
</template>

<script lang="ts">
    import { Vue, Component } from 'vue-property-decorator';
    import { ProductModule, productModule } from '../../store/product.module'
    import { format } from "date-fns"
    import { nl } from "date-fns/locale"
    import {
        ProductFooter,
        ProductDebug,
        ProductOptions,
        ProductDescription,
        ProductDeadline,
        ProductHeader
    } from './Product'
    
    @Component({
        components: {
            ProductDebug,
            ProductFooter,
            ProductOptions,
            ProductDescription,
            ProductDeadline,
            ProductHeader
        },
    })
    export default class AdminProduct extends Vue {
        productModule: ProductModule = productModule;
        
        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl })
        }

        beforeRouteEnter(to: any, from: any, next: any) {
            this.prepareComponent();
            next();
        }
        beforeRouteUpdate(to: any, from: any, next: any) {
            this.prepareComponent();
            next();
        }
        
        mounted() {
            this.prepareComponent();
        }
        
        prepareComponent() {
            // @ts-ignore $route does exist.
            if ((this.$route.params.id as unknown as number) !== (this.productModule.product.id as unknown as number)) {
                // @ts-ignore $route does exist.
                this.productModule.setId(this.$route.params.id as unknown as number);
                this.productModule.loadProduct();
            }
        }
    }
</script>
