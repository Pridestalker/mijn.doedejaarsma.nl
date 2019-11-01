<template>
    <footer>
        <small class="text-grey-light">
            Laatste aanpassing op: <span v-if="productModule.product.updated_at">{{ formattedDate(productModule.product.updated_at) }}</span>
        </small>
        
        <p class="text-grey-light">
            <small v-if="!$route.meta.editing">
                Klopt er iets niet? <router-link :to="{ name: 'product-edit' , params: { id: productModule.product.id }}">Aanpassen</router-link>
            </small>
            <small v-else>
                Alles opgelost, dan kan je <a href="#">opslaan</a>
            </small>
        </p>
    </footer>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator'
    import { productModule, ProductModule } from '../../../store/product.module'
    import { format } from "date-fns"
    import { nl } from "date-fns/locale"
    
    @Component
    export default class ProductFooter extends Vue {
        productModule: ProductModule = productModule;

        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl })
        }
    }
</script>
