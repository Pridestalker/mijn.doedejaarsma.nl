<template>
    <section class="content">
        <p>
            <b-button v-if="$route.meta.editing" icon-left="pen" size="is-small"></b-button>
            <span v-if="productModule.product.deadline">
                Deadline: {{ formattedDate(productModule.product.deadline) }}
            </span>
        </p>
        
    </section>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator'
    import { productModule, ProductModule } from '../../../store/product.module'
    import { format } from "date-fns"
    import { nl } from "date-fns/locale"

    @Component
    export default class ProductDeadline extends Vue {
        productModule: ProductModule = productModule;

        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl })
        }
    }
</script>
