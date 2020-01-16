export default {
	name: 'ProductSelector',
	data() {
		return {
			products: [],
			selected: null
		}
	},
	mounted () {
		this.init();
	},
	methods: {
		async init () {
			this.products = (await this.$http.get('/api/v2/standard_products')).data.data;
		}
	},
	watch: {
		selected: function (newSelected) {
			this.$emit('selected', newSelected)
		}
	}
}

