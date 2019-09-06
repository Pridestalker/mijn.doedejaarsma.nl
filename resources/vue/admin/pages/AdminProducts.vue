<template>
    <main>
        <b-field grouped group-multiline>
            <b-select v-model="params.per_page">
                <option value="1">1 per pagina</option>
                <option value="5">5 per pagina</option>
                <option value="15">15 per pagina</option>
                <option value="25">25 per pagina</option>
            </b-select>
            <b-dropdown multiple v-model="params.status">
                <button class="button is-primary" type="button" slot="trigger">
                    <span>Selected ({{ params.status.length }})</span>
                    <b-icon icon="menu-down"></b-icon>
                </button>
                <b-dropdown-item value="afgerond">Afgerond</b-dropdown-item>
                <b-dropdown-item value="opgepakt">Opgepakt</b-dropdown-item>
                <b-dropdown-item value="aangevraagd">Aangevraagd</b-dropdown-item>
            </b-dropdown>
        </b-field>
        <b-field grouped group-multiline>
            <b-checkbox v-model="headers" native-value="id">ID</b-checkbox>
            <b-checkbox v-model="headers" native-value="kind">Product type</b-checkbox>
            <b-checkbox v-model="headers" native-value="created_at">Aangevraagd op</b-checkbox>
            <b-checkbox v-model="headers" native-value="updated_at">Laatste aanpassing</b-checkbox>
            <b-checkbox v-model="headers" native-value="hours">Uren</b-checkbox>
        </b-field>
        <b-table
            :data="products"
            :loading="products.length === 0"
            
            paginated
            backend-pagination
            :total="productsModule.getMeta.total ? productsModule.getMeta.total : 0"
            :per-page="params.per_page"
            @page-change="onPageChange"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"
            
            hoverable
            ref="table"
        >
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" numeric :visible="headers.includes('id')">{{ props.row.id }}</b-table-column>
                <b-table-column field="name" label="Product naam" :visible="headers.includes('name')">
                    <router-link :to="{ name: 'product', params: { id: props.row.id }}">
                        {{ props.row.name }}
                    </router-link>
                </b-table-column>
                <b-table-column field="kind" label="Soort product" :visible="headers.includes('kind')">{{ props.row.soort }}</b-table-column>
                <b-table-column field="requestee" label="Aangevraagd door" :visible="headers.includes('requestee')">{{ props.row.owner.name }}</b-table-column>
                <b-table-column field="deadline" label="Deadline" :visible="headers.includes('deadline')">{{ formattedDate(props.row.deadline)}}</b-table-column>
                <b-table-column field="created_at" label="Aangevraagd op" :visible="headers.includes('created_at')">{{ formattedDate(props.row.created_at)}}</b-table-column>
                <b-table-column field="updated_at" label="Laatste aanpassing op" :visible="headers.includes('updated_at')">{{ formattedDate(props.row.updated_at)}}</b-table-column>
                <b-table-column field="hours" label="Uren" :visible="headers.includes('hours')">{{props.row.hours.total}}</b-table-column>
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
        
        <pre>
    {{ productsModule.allProducts }}
        </pre>
    </main>
</template>

<script lang="ts">
    import { Vue, Component, Watch } from 'vue-property-decorator';
    import { productsModule, ProductsModule } from '../../store/products.module'
    import { format } from "date-fns"
    import { nl } from "date-fns/locale"
    import { productModule } from '../../store/product.module'
    
    @Component
    export default class AdminProducts extends Vue {
        productsModule: ProductsModule = productsModule;
        products = [];
        
        params = {
            page: 1,
            per_page: 5,
            status: [
                'aangevraagd',
                'opgepakt'
            ],
        };
        
        headers: string[] = ['id', 'name', 'deadline', 'requestee'];
        
        async mounted() {
            this.fetchData();
        }
        
        async fetchData(): Promise<void> {
            this.products = [];
            this.productsModule.setParams(this.params);
            await this.productsModule.loadProducts();
            this.products = this.productsModule.allProducts;
            productModule.setProduct(this.products[0]);
        }

        onPageChange(page) {
            this.params.page = page;
            
            this.fetchData();
        }
        
        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl})
        }
        
        @Watch('params.per_page')
        paramsPerPageWatcher() {
            this.fetchData();
        }
        
        @Watch('params.status')
        paramsStatusWatcher() {
            this.fetchData();
        }
    }
</script>
