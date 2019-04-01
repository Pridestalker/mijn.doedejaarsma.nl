<template>
    <article class="d-flex align-items-center" v-if="product">
        <a :href="product.links.self.web">
            {{ product.name }}
        </a>
        <button class="btn ml-auto" @click.prevent="removeMe">
            <i class="fas fa-times"></i>
        </button>
    </article>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component({
    props: {
        notification: {
            type: Object,
            default: {},
        },
    },
})
export default class NotificationComponent extends Vue {
    product = null;
    owner = this.notification.data.user;
    
    beforeMount() {
        this.loadNotification();
    }
    
    async loadNotification() {
        this.product = (await this.$http.get(`/api/v1/products/${this.notification.data.id}`)).data.data;
    }
    
    async removeMe() {
        await this.$http.get(`/api/v1/user/notifications/delete/${this.notification.id}`);
        this.$emit('removed', { id: this.notification.id})
    }
}
</script>
