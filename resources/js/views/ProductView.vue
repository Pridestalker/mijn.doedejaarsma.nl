<template>
    <div>
        <block-loader-component v-if="loading"></block-loader-component>
        <product-component :id="id" v-show="!loading" @product-loaded="stopLoading"></product-component>
    </div>
</template>

<script>
    import BlockLoaderComponent from '../components/BlockLoaderComponent'
    import ProductComponent from '../components/Product/ProductComponent'
    export default {
        name: "ProductView",
        data() {
            return {
                loading: true,
            }
        },
        components: { ProductComponent, BlockLoaderComponent },
        props: {
            id: {
                type: Number,
                default: undefined
            }
        },
        methods: {
            stopLoading() {
                setTimeout(() => {
                    this.loading = false
                }, 800)
            },
        }
    }
</script>

<style scoped lang="scss">
</style>
