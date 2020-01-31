<template>
    <main>
        <b-field label="Kies een maand en jaar">
            <b-datepicker v-model="data" type="month" icon="calendar-range"/>
        </b-field>
        <b-table
            :data="products"
            :loading="products.length === 0"
            
            paginated
            backend-pagination
            :total="meta.total"
            :per-page="params.per_page"
            @page-change="onPageChange"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"
            
            detailed
            hoverable
            ref="table"
        >
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" numeric>{{ props.row.id }}</b-table-column>
                <b-table-column field="name" label="Naam product" @click="toggle(props.row)">{{ props.row.name }}</b-table-column>
                <b-table-column field="uren" label="Uren" width="40" numeric>{{ props.row.hours.total }}</b-table-column>
                <b-table-column field="referentie" label="Referentie">{{ props.row.referentie }}</b-table-column>
                <b-table-column field="kostenplaats" label="Kostenplaats">{{ props.row.kostenplaats.name }}</b-table-column>
                <b-table-column field="requestee" label="Aangevraagd door">{{ props.row.owner.name }}</b-table-column>
            </template>
            
            <template slot="detail" slot-scope="props" v-if="props.row.hours.data.length > 0">
                <hours-administration-detail :detail="props"></hours-administration-detail>
            </template>
    
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon icon="emoticon-sad" size="is-large"></b-icon>
                        </p>
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>
        </b-table>
    </main>
</template>

<script lang="ts">
    import { Vue, Component, Watch } from 'vue-property-decorator';
    import { productsModule } from '../../store/products.module';
    import { Product } from '../../constants/product.model';
    import { getMonth } from "date-fns";
    // @ts-ignore
    import HoursAdministrationDetail from '../modules/HoursAdministrationDetail';
    
    @Component({
        components: { HoursAdministrationDetail }
    })
    export default class DateAdministration extends Vue {
        products: Array<Product> = [];

        params = {
            page: 1,
            per_page: 5,
            hours_month_created: getMonth(new Date()) +1,
            hours_year_created: new Date().getFullYear()
        };

        meta = {};

        data = new Date();

        async mounted() {
            await this.fetchdata();
        }

        async fetchdata() {
            productsModule.setParams(this.params);
            await productsModule.loadProducts();
            this.products = productsModule.allProducts;
            this.meta = productsModule.getMeta;
        }

        onPageChange(page) {
            this.params.page = page;
            this.products = [];

            this.fetchdata();
        }

        toggle(row) {
            // @ts-ignore
            this.$refs.table.toggleDetails(row)
        }

        @Watch('data')
        dataWatcher(data){
            new Date(data);
            this.params.hours_month_created = data.getMonth() + 1;
            this.params.hours_year_created = data.getFullYear();
            this.products = [];

            this.fetchdata();
        }
    }
</script>
