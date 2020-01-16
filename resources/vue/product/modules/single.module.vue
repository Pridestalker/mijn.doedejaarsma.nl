<template>
    <card-container class="product-single-container">
        <router-link :to="{name: 'index'}">Terug naar het overzicht</router-link>
        <title-component>{{ product.name }}</title-component>
        <small class="text-muted" v-if="product.owner"><a :href="'mailto:' + this.product.owner.email + '?subject=Opmerkingen ' + this.product.name">{{ product.owner.name }}</a><span v-if="product.owner.team.length > 0"> van {{ product.owner.team[0].name }}</span></small>

        <div v-if="product.description">
            <span>Voor {{ product.name }} is de volgende opmerking gegeven:</span>
            <p>
                {{ product.description }}
            </p>
        </div>

        <div v-if="(userMod.hasRole('admin') || userMod.hasRole('designer'))">
            De opdracht is
            <span @click="statusChange = !statusChange">
                <span-underline hover :type="product.status">
                    {{product.status}}
                </span-underline>
            </span>
            <transition name="fade">
                <form v-if="statusChange" class="d-flex" @submit.prevent="updateStatus">
                    <select class="custom-select" v-model="product.status">
                        <option :value="'aangevraagd'">Aangevraagd</option>
                        <option :value="'opgepakt'">Opgepakt</option>
                        <option :value="'afgerond'">Afgerond</option>
                    </select>
                    <button type="submit" class="btn link">Aanpassen</button>
                </form>
            </transition>
        </div>

        <p v-else>
            {{ product.name }} is <span-underline title="status" :type="product.status">{{ product.status }}</span-underline>
        </p>


        <p v-if="product.deadline">
            De opdracht heeft de volgende deadline: <span-underline type="date">{{ formattedDate(product.deadline) }}</span-underline>
        </p>

        <div v-if="product.soort = 'drukwerk'">
            <span>Het gaat om een <span-underline :type="product.soort">{{ product.soort }}</span-underline> aanvraag</span>
            <ul v-if="product.options">
                <li v-for="(value, option) in getOptions(product.options)" :key="option">
                    {{ option }}: {{ value }}
                </li>
            </ul>
        </div>
        <div v-else-if="product.soort = 'digitaal'">
            <span>Het gaat om een <span-underline :type="product.soort">{{ product.soort }}</span-underline> aanvraag</span>
        </div>
        <p v-if="product.format">
            "{{ product.format }}" is het gewenste formaat.
        </p>
        <p v-if="product.hours">
            Gemaakte uren: <span-underline type="date">{{ formattedTime(product.hours.total) }}</span-underline>
        </p>
        <p v-if="product.attachment">
            <a :href="'/products/' + product.id + '/image'">
                Download voorbeeld
            </a>
        </p>
        <footer>
            <small class="text-muted pointer" v-if="product.updated_at" @click="fetchData" title="Gegevens updaten">
                Laatste update: {{ formattedUpdate }}
                door: {{ updatedBy }}
            </small>
        </footer>

        <footer v-if="userMod.hasRole('admin') || userMod.hasRole('designer')" class="timeForm">
            <h5>Uren toevoegen:</h5>
            <add-hours-component :user_id="user.id" :product_id="Number.parseInt(product.id)" v-if="user" @updated="fetchData" />
        </footer>
    </card-container>
</template>

<script lang="ts">
	import Component from 'vue-class-component';
	import Vue from 'vue';
	import { productModule } from '../../store/product.module';
	import { userModule } from '../../store/user.module';
	import { format, formatDistance } from 'date-fns';
	import { nl } from 'date-fns/locale';
	// @ts-ignore
	import AddHoursComponent from '../components/AddHoursComponent'
	// @ts-ignore
	import TitleComponent from '../../components/TitleComponent'
	// @ts-ignore
	import SpanUnderline from '../../components/SpanUnderline'
	// @ts-ignore
	import CardContainer from '../../components/CardContainer'
	// @ts-ignore
	import MagicButton from '../../components/MagicButton'
	import { Product } from '../../constants/product.model'

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
</script>

<style src="./single/style.scss" lang="scss" />
