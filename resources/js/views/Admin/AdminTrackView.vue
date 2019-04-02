<template>
    <main>
        <aside>
            Hier komen enkele filters
        </aside>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>uren</th>
                    <th>Opdrachtgever</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>
                        {{ product.id }}
                    </td>
                    <td>
                        {{ product.name }}
                    </td>
                    <td>
                        {{ product.hours.total }}
                    </td>
                    <td :team="product.owner.team[0].id">
                        {{ product.owner.team[0].name }}
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component
export default class AdminTrackView extends Vue {
    products = [];
    
    hours = [];
    
    async fetchData() {
        this.products = (await this.$http.get('/api/v1/products')).data.data;
        this.hours = (await this.$http.get('/api/v1/hours')).data.data;
    }
    
    mounted() {
        this.fetchData();
    }
}
</script>

