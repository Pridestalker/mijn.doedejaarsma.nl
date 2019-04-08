<template>
    <section class="row">
        <div class="col-md-12">
            Maand: <input type="number" v-model="month" class="form-control" min="0" max="12" />
        </div>
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
import { Watch } from 'vue-property-decorator';
import { format } from 'date-fns';
import { nl } from 'date-fns/locale';

@Component
export default class SingleTrackView extends Vue {
    id = null;
    hours = {};
    
    month = null;
    
    params = {}
    mounted() {
        this.id = this.$route.params.id
        this.params.product = this.id;
        this.fetchData();
    }
    
    async fetchData() {
        try {
            this.hours = (await this.$http.get(`/api/v1/hours`, { params: this.params })).data.data
        } catch (e) {
            console.warn(e.request)
        }
    }
    
    creationDate(date) {
        return format(new Date(date), 'cccc dd MMMM YYYY', { awareOfUnicodeTokens: true, locale: nl })
    }
    
    urenConverter(hour) {
        if (!hour) return;
        const time = String(hour).split('.');
        let decimal = `${((60 * parseInt(time[1]))/100)}`;
        decimal = decimal.length < 2 ? decimal + '0'  : decimal;
        return `${time[0]}:${decimal}`;
    }
    
    created() {
        this.debouncedFetchData = this.$_.debounce(this.fetchData, 500);
    }
    
    @Watch('month')
    monthWatcher(month, oldMonth) {
        this.params.month = month;
        this.debouncedFetchData();
    }
    
}
</script>

<style scoped>

</style>
