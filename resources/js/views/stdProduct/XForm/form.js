import DeadlineComponent from '../../../components/ProductForm/DeadlineComponent'
import lang from './nl_NL';

export default {
	name: "XForm",
	components: {
		DeadlineComponent
	},
	props: ['product'],
	data() {
		return {
			locations: []
		}
	},
	mounted() {
		this.getCostCentres()
	},
	methods: {
		isCorrectKey(key) {
			return !(key === 'id' || key === 'team')
		},
		isValidJson: (value) => {
			try {
				JSON.parse(value.toString())
			} catch (e) {
				return false;
			}
			return true;
		},
		isValidAttachment(url) {
			return url !== null
		},
		canHaveOptions() {
			if (typeof this.product !== 'object') {
				return false;
			}
			return (this.product.soort === 'Drukwerk' || this.product.soort === 'drukwerk');
		},
		async getCostCentres() {
			this.locations = (await this.$http.get('/api/v2/cost_centres')).data.data
		},
	},
	filters: {
		uppercase: (value) => value.toString().charAt(0).toUpperCase() + value.toString().slice(1),
		translate: (value) => lang[value.toLowerCase()]? lang[value.toLowerCase()] : value,
	}
}
