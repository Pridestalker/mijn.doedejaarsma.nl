import { VuexModule, Module, Mutation, Action } from 'vuex-class-modules';
import store from './product.store';
import axios from '../axios.service';

@Module
class ProductModule extends VuexModule {
    id = null;
    name = null;
    links = {};
    options = {};
    owner = {};
    description = null;
    options = null
    soort = null;
    status = null;
    hours = null;
    deadline = null;
    updated_at = null;
    created_at = null;
    attachment = null;
    factuur = null;
    kostenplaats = null;
    referentie = null;
    updated_by = null;

    get product() {
        return {
            id: this.id,
            name: this.name,
            description: this.description,
            attachment: this.attachment,
            factuur: this.factuur,
            format: this.format,
            soort: this.soort,
            kostenplaats: this.kostenplaats,
            referentie: this.referentie,
            status: this.status,
            hours: this.hours,
            deadline: this.deadline,
            owner: this.owner,
            options: this.options,
            links: this.links,
            created_at: this.created_at,
            updated_at: this.updated_at,
            updated_by: this.updated_by,
        }
    }

    @Mutation
    setId(id) {
        this.id = id;
    }

    @Mutation
    setName(name) {
        this.name = name;
    }

    @Mutation
    setDescription(desc) {
        this.description = desc;
    }

    @Mutation
    setKostenplaats(kostenplaats) {
        this.kostenplaats = kostenplaats;
    }

    @Mutation
    setReferentie(ref) {
        this.referentie = ref;
    }

    @Mutation
    setAttachment(attachment) {
        this.attachment = attachment;
    }

    @Mutation
    setLinks(links) {
        this.links = links;
    }

    @Mutation
    setOptions(options) {
        this.options = options;
    }

    @Mutation
    setOwner(owner) {
        this.owner = owner;
    }

    @Mutation
    setSoort(soort) {
        this.soort = soort;
    }

    @Mutation
    setStatus(status) {
        this.status = status;
    }

    @Mutation
    setHours(hours) {
        this.hours = hours;
    }

    @Mutation
    setDeadline(deadline) {
        this.deadline = deadline;
    }

    @Mutation
    setUpdatedAt(date) {
        this.updated_at = date;
    }

    @Mutation
    setCreatedAt(date) {
        this.created_at = date
    }

    @Mutation
    setUpdatedBy(user) {
        this.updated_by = user;
    }

    @Action
    async loadProduct() {
        return await this.fetchData();
    }

    async fetchData() {
        if (!this.id) throw new Error('No ID set');

        const product = (await axios.get(`/api/v1/products/${this.id}`)).data.data

        return this.setProductData(product);
    }

    @Action
    async updateStatus() {
        if (!this.id) throw new Error('No ID set');
        try {
            const product = (await axios.post(`/api/v1/products/${this.id}/edit`, { _method: 'patch', status: this.status })).data.data;
            return this.setProductData(product);
        } catch (e) {
            return e;
        }
    }

    setProductData(product) {
        this.setCreatedAt(product.created_at);
        this.setDeadline(product.deadline);
        this.setHours(product.hours);
        this.setLinks(product.links);
        this.setName(product.name);
        this.setOptions(product.options);
        this.setOwner(product.owner);
        this.setSoort(product.soort);
        this.setStatus(product.status);
        this.setUpdatedAt(product.updated_at);
        this.setAttachment(product.attachment);
        this.setDescription(product.description);
        this.setKostenplaats(product.kostenplaats);
        this.setUpdatedBy(product.updated_by);
        return product;
    }
}

export const productModule = new ProductModule({ store, name: 'product' });
