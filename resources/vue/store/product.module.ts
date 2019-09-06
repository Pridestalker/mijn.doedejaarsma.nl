import { VuexModule, Module, Mutation, Action } from 'vuex-class-modules/lib/index';
import store from './store';
import axios from '../axios.service';
import { Hours, Product } from "../constants/product.model";
import { UserModule } from "../constants/user.model";

@Module
export class ProductModule extends VuexModule {
    product?: Product = {};

    @Mutation
    setId(id: number) {
        this.product.id = id;
    }

    @Mutation
    setName(name: string) {
        this.product.name = name;
    }

    @Mutation
    setDescription(desc: string) {
        this.product.description = desc;
    }

    @Mutation
    setKostenplaats(kostenplaats: string) {
        this.product.kostenplaats = kostenplaats;
    }

    @Mutation
    setReferentie(ref: string) {
        this.product.referentie = ref;
    }

    @Mutation
    setAttachment(attachment: string) {
        this.product.attachment = attachment;
    }

    @Mutation
    setLinks(links: object) {
        this.product.links = links;
    }

    @Mutation
    setOptions(options: object) {
        this.product.options = options;
    }

    @Mutation
    setOwner(owner: UserModule) {
        this.product.owner = owner;
    }

    @Mutation
    setSoort(soort: string) {
        this.product.soort = soort;
    }

    @Mutation
    setStatus(status: string) {
        this.product.status = status;
    }

    @Mutation
    setHours(hours: Hours) {
        this.product.hours = hours;
    }

    @Mutation
    setDeadline(deadline: string) {
        this.product.deadline = deadline;
    }

    @Mutation
    setUpdatedAt(date: string) {
        this.product.updated_at = date;
    }

    @Mutation
    setCreatedAt(date: string) {
        this.product.created_at = date
    }

    @Mutation
    setUpdatedBy(user: UserModule) {
        this.product.updated_by = user;
    }

    @Mutation
    setProduct(product: Product) {
        this.product = {...product};
        return this.product;
    }

    @Action
    async loadProduct() {
        return await this.fetchData();
    }

    async fetchData(): Promise<Product> {
        // @ts-ignore
        if (!this.product.id) throw new Error('No ID set');

        const product = (await axios.get(`/api/v1/products/${this.product.id}`)).data.data as Product;

        return this.setProduct(product);
    }

    @Action
    async updateStatus(): Promise<Product> {
        // @ts-ignore
        if (!this.product.id) throw new Error('No ID set');

        try {
            const product = (await axios.post(`/api/v1/products/${this.product.id}/edit`, { _method: 'patch', status: this.product.status })).data.data as Product;
            return this.setProduct(product);
        } catch (e) {
            return e;
        }
    }

    @Action
    productSetter(product: Product) {
        this.setProduct(product);
    }
}

export const productModule = new ProductModule({ store, name: 'product' });
