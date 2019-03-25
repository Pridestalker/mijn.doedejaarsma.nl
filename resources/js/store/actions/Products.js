'use strict';
import { axios } from '../helpers/httpReq';

export default {
    get_products({commit}, {...params}) {
        return new Promise((resolve, reject) => {
            commit('fetch_products');
            axios
                .get('/api/v1/products', { params })
                .then((res) => {
                    commit('fetch_products_success', res.data.data);
                    resolve(res);
                })
                .catch((err) => {
                    commit('fetch_products_error', err);
                    reject(err);
                })
        });
    },
    async get_product({commit}, id) {
        return new Promise((resolve, reject) => {
            commit('fetch_product');
            axios
                .get('/api/v1/products', {product: id})
                .then((res) => {
                    commit('fetch_product_success', res.data.data)
                    resolve(res);
                })
                .catch((err) => {
                    commit('fetch_product_error', err);
                    reject(err);
                })
        });
    }
}
