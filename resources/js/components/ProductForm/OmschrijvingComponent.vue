<template>
    <div class="form-group">
        <label for="description">Omschrijving</label>
        <input type="text" class="form-control" id="description" name="description" aria-describedby="descriptionHelp" placeholder="Omschrijving van de opdracht..." v-model="omschrijving">
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
