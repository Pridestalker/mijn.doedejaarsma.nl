import { Action, Module, Mutation, VuexModule } from 'vuex-class-modules/lib/index';
import store from './store';
import axios from '../axios.service';

@Module
export class ProductsModule extends VuexModule {
    products = [];
    params = {
        per_page: 15,
        ordered: 'status',
        order: 'ASC'
    };
    meta = {};
    links = {};

    get allProducts() {
        return this.products;
    }

    get getMeta() {
        return this.meta;
    }

    get getLinks() {
        return this.links;
    }

    @Mutation
    setProducts(products) {
        this.products = products;
    }

    @Mutation
    setMeta(meta) {
        this.meta = meta;
    }

    @Mutation
    setLinks(links) {
        this.links = links;
    }

    @Mutation
    setParams({ ...params }) {
        for(let i in this.params) delete this.params[i];
        Object.assign(this.params, params);
    }

    @Action
    async loadProducts() {
        let products = await this.fetchProducts();
        this.setProducts(products.data);
        this.setMeta(products.meta);
        this.setLinks(products.links);
        return products.data;
    }

    async fetchProducts() {
        return new Promise((resolve, reject) => {
            axios.get('/api/v2/products', { params: this.params })
                .then((res) => {
                    resolve(res.data)
                })
                .catch((err) => {
                    reject(err);
                })
        });
    }
}

export const productsModule = new ProductsModule({ store, name: 'producten'});
