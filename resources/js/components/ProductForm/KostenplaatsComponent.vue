<template>
    <section>
        <div class="form-group">
            <label for="kostenplaats">Kostenplaats</label>
            <input type="text" class="form-control" id="kostenplaats" name="kostenplaats" aria-describedby="kostenplaatsHelp" placeholder="Voor vermelding op factuur" v-model="kostenplaats">
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
            }
        },
        mounted() {
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
    }
</script>

<style scoped>

</style>
