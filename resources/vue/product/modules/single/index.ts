import Component from 'vue-class-component';
import Vue from 'vue';
import { productModule } from '../../../store/product.module';
import { userModule } from '../../../store/user.module';
import { format, formatDistance } from 'date-fns';
import { nl } from 'date-fns/locale';
// @ts-ignore
import AddHoursComponent from '../../components/AddHoursComponent'
// @ts-ignore
import TitleComponent from '../../../components/TitleComponent'
// @ts-ignore
import SpanUnderline from '../../../components/SpanUnderline'
// @ts-ignore
import CardContainer from '../../../components/CardContainer'
// @ts-ignore
import MagicButton from '../../../components/MagicButton'
import { Product } from '../../../constants/product.model'

// @ts-ignore
@Component({
	components: { MagicButton, CardContainer, SpanUnderline, TitleComponent, AddHoursComponent },
})
export default class SingleModule extends Vue {
	id?: number = null;
	product?: Product = {};
	user?: object = null;
	userMod = userModule;
	statusChange: boolean = false;

	created() {
		// @ts-ignore
		this.id = this.$route.params.id;
	}

	async mounted(): Promise<void> {
		await this.fetchData();
		await this.fetchUser();
	}

	async fetchUser(): Promise<void> {
		await userModule.loadUser();
		this.user = userModule.user;
	}

	async fetchData(): Promise<void> {
		productModule.setId(this.id as number);
		await productModule.loadProduct();
		this.product = productModule.product;
	}

	async updateStatus(): Promise<void> {
		productModule.setId(this.id as number);
		productModule.setStatus(this.product.status as string);
		await productModule.updateStatus();
		this.product = productModule.product;
		this.statusChange = false;
	}

	downloadAttachment(url) {
		// @ts-ignore
		browser.downloads.download({
			url: url,
			// @ts-ignore
			filename: `voorbeeld-${this.product.name}.${filename.split('.').pop()}`,
			conflictAction : 'uniquify'
		})
	}

	get formattedUpdate() {
		if (!this.product)
			return;
		return formatDistance(new Date(this.product.updated_at), new Date(), { addSuffix: true, locale: nl });
	}

	formattedDate(date) {
		try {
			return format(new Date(date), 'EEEE dd MMMM yyyy', { locale: nl })
		} catch {
			return date;
		}
	}

	getOptions(options) {
		try {
			return JSON.parse(options);
		} catch	{
			return [];
		}
	}

	formattedTime(time) {
		if (!this.product) {
			return '';
		}

		if (!this.product.hours) {
			return '';
		}

		let decimal = (this.product.hours.total - Math.floor(this.product.hours.total)).toPrecision(2) as unknown as number * 100;

		if (!decimal) {
			return Math.floor(this.product.hours.total)
		}

		return `${Math.floor(this.product.hours.total)}:${(decimal/100 * 60).toPrecision(2)}`
	}

	get updatedBy() {
		if (this.product.status === 'aangevraagd' && !this.product.updated_by) {
			return this.product.owner.name;
		}

		return this.product.updated_by? this.product.updated_by.name : 'Onbekend';
	}
}
