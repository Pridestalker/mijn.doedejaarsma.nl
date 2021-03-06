<template>
    <div>
        <block-loader-component size="xsmall" v-show="loading"></block-loader-component>
        <main v-show="!loading">
            <aside>
                <form @submit.prevent="searchForMe" class="text-right">
                    <input type="text" v-model="params.product_name" />
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </aside>
            <section v-if="!error">
                <table class="table">
                    <thead>
                        <tr>
                            <th @click="orderBy('id')" class="table-header">#</th>
                            <th @click="orderBy('name')" class="table-header">Naam</th>
                            <th @click="orderBy('user_id')" class="table-header">Aanvraag door</th>
                            <th @click="orderBy('status')" class="table-header">Status</th>
                            <th @click="orderBy('deadline')" class="table-header">Deadline</th>
                        </tr>
                    </thead>
                    <tr v-for="product in products" :key="product.id">
                        <td>
                            <a :href="product.links.self.web">
                                {{ product.id }}
                            </a>
                        </td>
                        <td>
                            <a :href="product.links.self.web">
                                {{ product.name }}
                            </a>
                        </td>
                        <td>
                            {{ product.owner.name }}
                        </td>
                        <td>
                            {{ product.status }}
                        </td>
                        <td>
                            {{ product.deadline }}
                        </td>
                    </tr>
                </table>
                <aside v-if="pagination && meta">
                    <nav>
                        <button class="btn" @click="goToFirst" :disabled="params.page <= 1"><i class="fas fa-angle-double-left"></i></button>
                        <button class="btn" @click="goToPrev" :disabled="params.page <= 1"><i class="fas fa-angle-left"></i></button>
                        <button class="btn" @click="goToNext" :disabled="params.page >= meta.last_page"><i class="fas fa-angle-right"></i></button>
                        <button class="btn" @click="goToLast" :disabled="params.page >= meta.last_page"><i class="fas fa-angle-double-right"></i></button>
                    </nav>
                </aside>
            </section>
            <section v-if="error">
                <div class="alert alert-warning">
                    {{ error }}
                </div>
            </section>
        </main>
    </div>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

import BlockLoaderComponent from '../../components/BlockLoaderComponent'

@Component({
    components: { BlockLoaderComponent },
})
export default class ProductsOverView extends Vue {
    loading = true;
    error = false;
    
    products = [];
    pagination = {};
    meta = {};
    params = {
        per_page: 15,
        order_by: 'status',
        order: 'ASC'
    };
    
    mounted() {
        this.params.page = 1;
        this.fetchData();
    }
    
    stopLoading() {
        setTimeout(() => {
            this.loading = false
        }, 800)
    }

    async fetchData() {
        this.loading = true;
        try {
            let res = await this.$store.dispatch('get_products', this.params);
            this.meta = res.data.meta;
            this.pagination = res.data.links;
            this.products = this.$store.getters.all_products;
            this.stopLoading();
        } catch (e) {
            this.stopLoading();
            if (e.response.status === 429) {
                this.error = 'Er zijn te veel aanvragen gedaan, probeer het nog een keer met een minuutje.'
            } else {
                this.error = e.message
                console.warn(e)
            }
        }
    }
    
    goToFirst() {
        this.params.page = 1;
        this.fetchData();
    }

    goToPrev() {
        this.params.page = (this.meta.current_page - 1);
        this.fetchData();
    }

    goToNext() {
        this.params.page = (this.meta.current_page + 1);
        this.fetchData();
    }

    goToLast() {
        this.params.page = this.meta.last_page;
        this.fetchData();
    }

    searchForMe() {
        this.fetchData();
    }

    orderBy(param) {
        this.params.order_by = param;
        this.params.order = this.params.order === 'DESC'? 'ASC': 'DESC';

        this.fetchData();
    }
}
</script>

<style scoped>
    .table-header {
        color: var(--primary);
        cursor: pointer;
    }
</style>
