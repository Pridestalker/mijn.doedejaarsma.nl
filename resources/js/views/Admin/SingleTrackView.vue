<template>
    <section class="row">
        <div class="col-md-6 my-2" v-for="hour in hours" :key="hour.id">
            <div class="card">
                <div class="card-header">
                    {{ creationDate(hour.created_at.date) }}
                </div>
                <div class="card-body">
                    <strong>{{ hour.user.data.name }}</strong> heeft <i>{{ creationDate(hour.created_at.date) }}</i> <strong>{{ urenConverter(hour.hours) }}</strong> uur gemaakt
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import { format } from 'date-fns';
import { nl } from 'date-fns/locale'

@Component
export default class SingleTrackView extends Vue {
    id = null;
    hours = {};
    
    mounted() {
        this.fetchData();
    }
    
    async fetchData() {
        const id = this.id = this.$route.params.id
        let params = {
            product: id,
        };
        try {
            this.hours = (await this.$http.get(`/api/v1/hours?product=${id}`)).data.data
        } catch (e) {
            console.warn(e.request)
        }
    }
    
    creationDate(date) {
        return format(new Date(date), 'cccc dd MMMM YYYY', { awareOfUnicodeTokens: true, locale: nl })
    }
    
    // Is string
    urenConverter(hour) {
        const time = hour.split('.')
        let decimal = `${((60 * time[1])/100)}`
        decimal = decimal.length < 2 ? '0' + decimal : decimal;
        
        console.log(decimal.length)
        return `${time[0]}:${decimal}`;
    }
}
</script>

<style scoped>

</style>
