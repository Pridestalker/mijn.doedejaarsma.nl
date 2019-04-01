<template>
    <div>
        <block-loader-component size="xsmall" v-if="loading"></block-loader-component>
        <product-component :id="id" v-show="!loading" @product-loaded="stopLoading"></product-component>
    </div>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import BlockLoaderComponent from '../../components/BlockLoaderComponent'
import ProductComponent from '../../components/Product/ProductComponent'

@Component({
    components: { ProductComponent, BlockLoaderComponent },
    props: {
        id: {
            type: Number,
            default: undefined
        }
    }
})
export default class ProductView extends Vue {
    loading = true;
    
    stopLoading() {
        setTimeout(() => {
            this.loading = false;
        }, 587)
    }
}
</script>

<style scoped lang="scss">
</style>
