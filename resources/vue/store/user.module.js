import { Action, Module, Mutation, VuexModule } from 'vuex-class-modules';
import store from './store';
import axios from '../axios.service';

@Module
export class UserModule extends VuexModule {
    user = {};
    roles = [];

    get role() {
        return this.roles;
    }

    hasRole(needle) {
        return this.role.includes(needle);
    }

    @Mutation
    setUser(user) {
        this.user = user
    }

    @Mutation
    setRoles(roles) {
        this.roles = roles;
    }

    @Action
    async loadUser() {
        if (!this.user.id) {
            const user = await this.fetchData();
            this.setUser(user);
            this.setRoles(user.role);
        }
        return this.user;
    }

    async fetchData() {
        return (await axios.get('/api/v1/user/whoami')).data.data;
    }
}

export const userModule = new UserModule({store, name: 'user'});
