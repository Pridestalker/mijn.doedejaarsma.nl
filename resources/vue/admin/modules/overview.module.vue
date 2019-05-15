<template>
    <card-container class="admin-dashboard-container">
        <title-component>Admin overzicht</title-component>
        <small class="text-muted" v-if="meta">{{ meta.from? meta.from : 0 }} - {{ meta.to? meta.to : 0 }} van de {{ meta.total ? meta.total : 0 }} <span>producten</span></small>
        
        <table-component>
            <!--suppress HtmlUnknownBooleanAttribute, XmlUnboundNsPrefix -->
            <template v-slot:thead>
                <tr>
                    <th>Naam</th>
                    <th class="hide-mobile">Bedrijf</th>
                    <th>Deadline</th>
                    <th>Uren</th>
                </tr>
            </template>
            <tr v-for="product in products" :key="product.id" class="product-table-row" @click.prevent="goToSingle(product.id)">
                <td>
                    {{ product.name }}
                </td>
                <td class="hide-mobile" v-if="product.owner">
                    {{ product.owner.team[0].name }}
                </td>
                <td>
                    {{ formattedDate(product.deadline) }}
                </td>
                <td>
                    {{ product.hours.total }}
                </td>
            </tr>
        </table-component>
        
        <aside>
            <a href="#" @click.prevent="goToPage('first')">
                <i class="fas fa-angle-double-left "></i>
            </a>
            <a href="#" @click.prevent="goToPage('prev')">
                <i class="fas fa-angle-left"></i>
            </a>
            <a href="#" @click.prevent="goToPage('next')">
                <i class="fas fa-angle-right"></i>
            </a>
            <a href="#" @click.prevent="goToPage('last')">
                <i class="fas fa-angle-double-right"></i>
            </a>
        </aside>
        
    </card-container>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import TitleComponent from '../../components/TitleComponent'
import { productsModule } from '../../store/products.module'
import { format } from 'date-fns';
import { nl } from 'date-fns/locale';
import CardContainer from '../../components/CardContainer'
import TableComponent from '../../components/TableComponent'

@Component( {
    components: { TableComponent, CardContainer, TitleComponent },
} )
export default class OverviewModule extends Vue {
    products = [];
    meta = {};
    
    params = {
        page: 1,
        per_page: 15,
        ordered: ['status', 'deadline'],
        status: ['afgerond'],
        team_name: null
    }
    
    async mounted() {
        await this.fetchData();
    }
    
    async fetchData() {
        productsModule.setParams(this.params);
        await productsModule.loadProducts();
        this.products = productsModule.allProducts;
        this.meta = productsModule.getMeta;
    }

    goToSingle(id) {
        this.$router.push({ name: 'single', params: { id }});
    }

    goToPage(page) {
        console.log(this.params.page)
        switch (page) {
            case 'first':
                this.params.page = 1;
                break;
            case 'last':
                this.params.page = this.meta.last_page;
                break;
            case 'next':
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
    
    formattedDate(date) {
        return format(new Date(date), 'cccc dd MMMM YYYY', { awareOfUnicodeTokens: true, locale: nl})
    }
}
</script>

<style scoped lang="scss">
</style>
