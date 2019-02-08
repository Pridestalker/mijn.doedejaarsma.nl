<template>
    <div class="form-group">
        <label for="kostenplaats">Kostenplaats</label>
        <input type="text" class="form-control" id="kostenplaats" name="kostenplaats" aria-describedby="kostenplaatsHelp" placeholder="Kostenplaats van de opdracht..." v-model="kostenplaats">
    </div>
</template>

<script>
    export default {
        name: "KostenplaatsComponent",
        data() {
            return {
                kostenplaats: ''
            }
        },
        mounted() {
            if (localStorage.getItem('product_kostenplaats'))
                this.kostenplaats = localStorage.getItem('product_kostenplaats')
        },
        watch: {
            kostenplaats() {
                localStorage.setItem('product_kostenplaats', this.kostenplaats)
            }
        },
    }
</script>

<style scoped>

</style>
