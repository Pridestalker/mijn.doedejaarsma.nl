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
                <b-table-column field="kostenplaats" label="Kostenplaats">{{ props.row.kostenplaats }}</b-table-column>
                <b-table-column field="requestee" label="Aangevraagd door">{{ props.row.owner.name }}</b-table-column>
            </template>
            
            <template slot="detail" slot-scope="props" v-if="props.row.hours.data.length > 0">
                <b-table :data="props.row.hours.data">
                    <template slot-scope="props">
                        <b-table-column field="id" label="ID" width="40" numeric>{{ props.row.id }}</b-table-column>
                        <b-table-column field="user" label="Gebruiker">{{ props.row.user.data.name }}</b-table-column>
                        <b-table-column field="hours" label="Uren" width="40" numeric>{{ props.row.hours }}</b-table-column>
                        <b-table-column field="creation" label="Gemaakt op">{{ formattedDate(props.row.created_at) }}</b-table-column>
                    </template>
                </b-table>
            </template>
        </b-table>
    </main>
</template>

<script lang="ts">
    import { Vue, Component, Watch } from 'vue-property-decorator';
    import { productsModule } from '../../store/products.module';
    import { Product } from '../../constants/product.model'
    import { format, getMonth } from "date-fns"
    import { nl } from "date-fns/locale"

    @Component
    export default class NewOverviewModule extends Vue {
        products: Array<Product> = [];
        
        params = {
            page: 1,
            per_page: 15,
            hours_month_created: getMonth(new Date()) +1,
            hours_year_created: new Date().getFullYear()
        };
        
        meta = {};
        
        data = new Date();
        
        async mounted() {
            console.log(new Date().getMonth());
            await this.fetchdata();
        }
        
        async fetchdata() {
            productsModule.setParams(this.params);
            await productsModule.loadProducts();
            this.products = productsModule.allProducts;
            this.meta = productsModule.getMeta;
            
            console.log(this.products);
        }
        
        onPageChange(page) {
            this.params.page = page;
            this.fetchdata();
        }

        toggle(row) {
            // @ts-ignore
            this.$refs.table.toggleDetails(row)
        }

        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl})
        }
        
        @Watch('data')
        dataWatcher(data){
            new Date(data);
            this.params.hours_month_created = data.getMonth() + 1;
            this.params.hours_year_created = data.getFullYear();
            
            this.fetchdata();
        }
    }
</script>
