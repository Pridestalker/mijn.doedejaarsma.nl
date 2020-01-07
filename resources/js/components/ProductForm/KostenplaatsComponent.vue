<template>
    <section>
        <div class="form-group">
            <label for="kostenplaats">Kostenplaats</label>
            <select class="custom-select" id="kostenplaats" name="kostenplaats" aria-describedby="kostenplaatsHelp" v-model="kostenplaats">
                <option v-for="location in locations" :key="location.id" :value="location.id">
                    {{ location.name }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="referentie">Referentie</label>
            <input type="text" name="referentie" id="referentie" class="form-control" placeholder="Voor vermelding op factuur" v-model="referentie">
        </div>
    </section>
</template>

<script>
    export default {
        name: "KostenplaatsComponent",
        data() {
            return {
                kostenplaats: '',
                referentie: '',
                locations: () => ([]),
            }
        },
        mounted() {
            this.getCostCentres();

            if (localStorage.getItem('product_kostenplaats'))
                this.kostenplaats = localStorage.getItem('product_kostenplaats')

            if (localStorage.getItem('product_referentie'))
                this.kostenplaats = localStorage.getItem('product_referentie')

        },
        watch: {
            kostenplaats() {
                localStorage.setItem('product_kostenplaats', this.kostenplaats)
            },
            referentie() {
                localStorage.setItem('product_referentie', this.referentie);
            }
        },
        methods: {
            async getCostCentres() {
                this.locations = (await this.$http.get('/api/v2/cost_centres')).data.data
            }
        }
    }
</script>
