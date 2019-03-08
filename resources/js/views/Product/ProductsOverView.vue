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
            <section>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Naam</th>
                            <th>Aanvraag door</th>
                            <th>Status</th>
                            <th>Deadline</th>
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
        </main>
    </div>
</template>

<script>
    import BlockLoaderComponent from '../../components/BlockLoaderComponent'
    export default {
        name: "ProductsOverView",
        components: { BlockLoaderComponent },
        data() {
            return {
                loading: true,
                products: [],
                pagination: {},
                meta: {},
                params: {},
            }
        },
        methods: {
            stopLoading() {
                setTimeout(() => {
                    this.loading = false
                }, 800)
            },
            fetchData() {
                this.loading = true;
                this.params.per_page = 15;
                
                this.$store.dispatch('get_products', this.params)
                    .then((res) => {
                        this.meta = res.data.meta;
                        this.pagination = res.data.links;
                        this.products = this.$store.getters.all_products;
                        this.stopLoading();
                    })
            },
            goToFirst() {
                this.params.page = 1
                this.fetchData();
            },
            goToPrev() {
                this.params.page = (this.meta.current_page - 1);
                this.fetchData();
            },
            goToNext() {
                this.params.page = (this.meta.current_page + 1);
                this.fetchData();
            },
            goToLast() {
                this.params.page = this.meta.last_page;
                this.fetchData();
            },
            searchForMe() {
                this.fetchData();
            }
        },
        mounted() {
            this.params.page = 1;
            this.fetchData();
        }
    }
</script>

<style scoped></style>
