'use strict';
import { axios } from '../helpers/httpReq';

export default {
    get_all_notifications({commit}) {
        return new Promise((resolve, reject) => {
            commit('fetch_notifications')
            axios
                .get('/api/v1/user/notifications')
                .then((res) => {
                    commit('fetch_notifications_success', res.data);
                    resolve(res);
                })
                .catch((err) => {
                    commit('fetch_notifications_error', err);
                    reject(err);
                })
        })
    }
}
