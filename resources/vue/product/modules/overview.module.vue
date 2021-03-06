<template>
    <card-container>
        <title-component>Overzicht</title-component>
        <small class="text-muted" v-if="meta">{{ meta.from? meta.from : 0 }} - {{ meta.to? meta.to : 0 }} van de {{ meta.total ? meta.total : 0 }} <span>producten</span></small>

        <table-component>
            <template v-slot:thead>
                <tr>
                    <th>Naam</th>
                    <th class="hide-mobile">Door</th>
                    <th>Deadline</th>
                    <th>Status</th>
                </tr>
            </template>
            <tr v-for="product in products" :key="product.id" class="product-table-row" :style="{ 'opacity': getProductRowOpacity(product.updated_at) }" @click.prevent="goToSingle(product.id)">
                <td>
                    {{ product.name }}
                </td>
                <td class="hide-mobile" v-if="product.owner">
                    {{ product.owner.name }}
                </td>
                <td :class="getDeadlineClass(product.deadline)">
                    {{ formattedDate(product.deadline) }}
                </td>
                <td>
                    {{ product.status }}
                </td>
            </tr>
        </table-component>

        <aside>
            <a href="#" @click.prevent="goToPage('first')">
                <i class="fas fa-angle-double-left"/>
            </a>
            <a href="#" @click.prevent="goToPage('prev')">
                <i class="fas fa-angle-left"/>
            </a>
            <a href="#" @click.prevent="goToPage('next')">
                <i class="fas fa-angle-right"/>
            </a>
            <a href="#" @click.prevent="goToPage('last')">
                <i class="fas fa-angle-double-right"/>
            </a>
        </aside>

        <aside class="product-dashboard-fabcontainer">
            <a href="#" class="product-dashboard-fab" @click.prevent="filter.open = !filter.open">
                <i class="fas fa-sliders-h mr-2"/> Filter
            </a>
        </aside>

        <aside class="product-dashboard-faddcontainer">
            <a href="/products/create" class="product-dashboard-fab">
                <i class="fas fa-folder-plus"/>
            </a>
        </aside>

		<transition name="appear">
			<aside class="product-dashboard-filter" v-show="filter.open">
				<h2>Filter</h2>
				<form class="form-filter">
					<h5 class="my-2">Status</h5>
					<div>
						<input type="checkbox" id="aangevraagd" v-model="params.status" :value="'aangevraagd'"/>
						<label for="aangevraagd">Aangevraagd</label>
					</div>
					<div>
						<input type="checkbox" id="opgepakt" v-model="params.status" :value="'opgepakt'" />
						<label for="opgepakt">Opgepakt</label>
					</div>
					<div>
						<input type="checkbox" id="afgerond" v-model="params.status" :value="'afgerond'" />
						<label for="afgerond">Afgerond</label>
					</div>

					<h5 class="my-2">Per pagina</h5>
					<div>
						<label for="perPage">Aanvragen per pagina</label>
						<select class="custom-select" v-model="params.per_page" id="perPage">
							<option :value="15">15</option>
							<option :value="20">20</option>
							<option :value="35">35</option>
							<option :value="50">50</option>
						</select>
					</div>

					<h5 class="my-2">Sorteren</h5>
					<div>
						<input type="checkbox" class="custom-checkbox" v-model="params.ordered" :value="'name'" id="order_naam">
						<label for="order_naam">Sorteer op naam</label>
					</div>
					<div>
						<input type="checkbox" class="custom-checkbox" v-model="params.ordered" :value="'deadline'" id="order_deadline">
						<label for="order_deadline">Sorteer op deadline</label>
					</div>
					<div>
						<input type="checkbox" class="custom-checkbox" v-model="params.ordered" :value="'status'" id="order_status">
						<label for="order_status">Sorteer op status</label>
					</div>

					<h5 class="my-2">Team</h5>
					<div>
						<input type="checkbox" v-model="params.team" id="wholeTeam">
						<label for="wholeTeam">Alles van team ophalen</label>
					</div>
				</form>
			</aside>
		</transition>
	</card-container>
</template>

<script lang="ts">
	import Component from 'vue-class-component';
	import Vue from 'vue';
	import { Watch } from 'vue-property-decorator';
	import { productsModule } from '../../store/products.module';
	import { differenceInDays, format, isAfter, isBefore } from 'date-fns';
	import { nl } from 'date-fns/locale';
	// @ts-ignore
	import TitleComponent from '../../components/TitleComponent'
	// @ts-ignore
	import CardContainer from '../../components/CardContainer'
	// @ts-ignore
	import TableComponent from '../../components/TableComponent'
	import { Product } from "../../constants/product.model"

	@Component( {
    components: { TableComponent, CardContainer, TitleComponent },
} )
export default class OverviewModule extends Vue {
    products?: Array<Product> = [];
    meta = {};
    params = {
        page: 1,
        per_page: 15,
        ordered: ['status', 'deadline'],
        status: ['aangevraagd', 'opgepakt'],
        team: true,
    };

    filter = {
        open: false,
    };

    async mounted(): Promise<void> {
        await this.fetchData();
    }

    async fetchData(): Promise<void> {
        productsModule.setParams(this.params);
        await productsModule.loadProducts();
        this.products = productsModule.allProducts;
        this.meta = productsModule.getMeta;
    }

    // noinspection JSMethodCanBeStatic
    formattedDate(date): string {
    	try {
 	       return format(new Date(date), 'EEEE dd MMMM yyyy', { locale: nl })
		} catch {
    		return date;
		}
    }

    goToSingle(id: number): void {
        // @ts-ignore
        this.$router.push({ name: 'single', params: { id }});
    }

    goToPage(page: string): void {
        switch (page) {
            case 'first':
                this.params.page = 1;
                break;
            case 'last':
                // @ts-ignore
                this.params.page = this.meta.last_page;
                break;
            case 'next':
                // @ts-ignore
                (this.params.page < this.meta.last_page) ?
                    this.params.page++ : console.warn('Je bent al op de laatste pagina.');
                break;
            case 'prev':
                (this.params.page > 1) ?
                    this.params.page-- : console.warn('Je bent al op de eerste pagina.');
                break;
        }

        this.fetchData();
    }

    // noinspection JSMethodCanBeStatic
    getDeadlineClass(deadline): Array<string> {
        const Class: string[] = [];
        if (isAfter(new Date(), new Date(deadline))) {
            Class.push('is-past');
        }

        if (isBefore(new Date(), new Date(deadline))) {
            Class.push('is-future');
        }

        return Class;
    }

    getProductRowOpacity(date): number {
        const diff = differenceInDays(new Date(), new Date(date));

        if (diff >= 14) {
            return 0.55
        }
    }

    @Watch('params', { immediate: true, deep: true })
    propsWatcher(params, oldParams): void {
        this.fetchData();
    }
}
</script>


<style scoped lang="scss">
    .product-table-row {
        border-bottom: 1px solid #333;
        cursor: pointer;
        > td {
            padding: 8px 0;
        }
    }

    .product-dashboard-filter {
        position: absolute;
        width: 75%;
        height: 100%;
        background: #1a174d;
        color: #ffffff;
        top: 0;
        left: 25%;
        border-radius: inherit;
        padding: inherit;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -ms-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
        transform-origin: right;
        overflow-y: scroll;
    }
	.appear-enter-active {
		animation-name: appear;
		animation-duration: 300ms;
		animation-iteration-count: 1;
	}


	.appear-leave-active {
		animation-name: appear;
		animation-duration: 300ms;
		animation-iteration-count: 1;
		animation-direction: reverse;
	}

    @keyframes appear {
        0% {
            transform: scale(0, 1);
        }
        100% {
            transform: scale(1,1);
        }
        0% {
            transform: scale(0,1);
        }
    }

    .product-dashboard-fabcontainer {
        position: absolute;
        top: -1rem;
        right: .7rem;
        font-size: 1.125rem;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .product-dashboard-fab {
        top: calc(100% - 1rem);
        right: 4rem;
        font-size: 1.125rem;
		padding: .5rem 3rem;
        z-index: 1;
        background: #ef8615;
        color: #fff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
		box-shadow: 0 3px 6px rgba(51, 51, 51, 0.2)
	}

    .product-dashboard-faddcontainer {
		display: none;
        position: absolute;
        left: 4rem;
        top: calc(100% - 1rem);;
    }

    .is-past {
        color: #e0a800;
    }

    .is-future {
        color: #0a2315;
    }

    @media screen and (max-width: 414px) {
        .hide-mobile {
            display: none;
        }
    }
</style>
