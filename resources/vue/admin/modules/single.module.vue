<template>
    <section>
        <card-container v-if="product.hours">
            <router-link :to="{name: 'index'}">Terug naar het overzicht</router-link>
            <title-component>{{ product.name }}</title-component>
        
            <table-component>
                <tr>
                    <th scope="row">Totaal aantal uren</th>
                    <td>{{ product.hours.total }}</td>
                </tr>
                <tr>
                    <th scope="row">Aantal rijen</th>
                    <td>{{ product.hours.count }}</td>
                </tr>
                <tr>
                    <th scope="row">Opdrachtgever</th>
                    <td>{{ product.owner.team[0].name }}</td>
                </tr>
                <tr>
                    <th scope="row">Aanvraag door</th>
                    <td>{{ product.owner.name }}</td>
                </tr>
            </table-component>
        </card-container>
        
        <div class="row mt-4" v-if="product.hours">
            <div v-for="hour in product.hours.data" :key="hour.id" class="col-md-6">
                <card-container v-if="hour">
                    <title-component>
                        {{ hour.user.data.name }}
                    </title-component>
                    <small class="text-muted" v-if="hour.created_at">
                        Ingevoerd op: {{ formattedDate(hour.created_at.date) }}
                    </small>
                    <p v-if="hour.hours">Aantal uren: {{ hour.hours }}</p>
                </card-container>
            </div>
        </div>
    </section>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import { productModule } from '../store/product.module';
import { userModule } from '../store/user.module';
import CardContainer from '../../components/CardContainer';
import TitleComponent from '../../components/TitleComponent';
import TableComponent from '../../components/TableComponent';
import { format } from 'date-fns';
import { nl } from 'date-fns/locale';


@Component( {
    components: { TableComponent, TitleComponent, CardContainer },
} )
export default class SingleModule extends Vue {
    id = null;
    product = {};
    user = null;
    userModule = userModule;
    
    created() {
        this.id = this.$route.params.id;
    }
    
    async mounted() {
        await this.fetchData();
    }
    
    async fetchData() {
        productModule.setId(this.id);
        await productModule.loadProduct();
        this.product = productModule.product;
    }

    formattedDate(date) {
        return format(new Date(date), 'cccc dd MMMM YYYY', { awareOfUnicodeTokens: true, locale: nl})
    }
}

</script>

<style scoped>

</style>
