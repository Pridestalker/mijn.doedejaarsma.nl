<template>
	<section>
		<product-selector @selected="selected" />
		<div v-if="product">
			<x-form :product="product" />
		</div>
		<div class="d-flex justify-content-between">
			<submit-component />
		</div>
	</section>
</template>

<script>
import SubmitComponent from '../components/ProductForm/SubmitComponent'
import ProductSelector from './stdProduct/ProductSelector'
import XForm from './stdProduct/XForm'

export default {
	name: 'CreateStdProductView',
	components: {
		SubmitComponent,
		ProductSelector,
		XForm
	},
	data() {
		return {
			product: null
		}
	},
	mounted() {},
	methods: {
		async selected(id) {
			this.product = (await this.$http.get(`/api/v2/standard_products/${id}`)).data.data
		}
	}
}
</script>
