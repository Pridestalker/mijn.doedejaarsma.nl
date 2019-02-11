<template>
    <div class="form-group">
        <label for="description">Omschrijving</label>
        <textarea rows="3" class="form-control" id="description" name="description" aria-describedby="descriptionHelp" placeholder="Bijvoorbeeld: Een flyer ter promotie van de open dag op zaterdag 2 augustus om 16.00 uur. De locatie is ons hoofdkantoor. Graag onze huisstijl regels aanhouden." v-model="omschrijving">
        </textarea>
        <small id="descriptionHelp" class="form-text text-muted">Voer hier een duidelijke omschrijving van de opdracht in.</small>
    </div>
</template>

<script>
    export default {
        name: "OmschrijvingComponent",
        data() {
            return {
                omschrijving: ''
            }
        },
        mounted() {
            if (localStorage.getItem('product_omschrijving'))
                this.omschrijving = localStorage.getItem('product_omschrijving')
        },
        watch: {
            omschrijving() {
                localStorage.setItem('product_omschrijving', this.omschrijving)
            }
        },
    }
</script>

<style scoped>

</style>
