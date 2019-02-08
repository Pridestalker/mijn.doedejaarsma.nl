<template>
    <div class="form-group">
        <label for="name">Naam</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Naam van de opdracht..." required autofocus v-model="name">
        <small id="nameHelp" class="form-text text-muted">Voer hier een beschrijvende naam van de opdracht in.</small>
    </div>
</template>

<script>
    export default {
        name: "NaamComponent",
        data() {
            return {
                name: ''
            }
        },
        mounted() {
            if (localStorage.getItem('product_name'))
                this.name = localStorage.getItem('product_name')
        },
        watch: {
            name() {
                localStorage.setItem('product_name', this.name)
            }
        },
    }
</script>

<style scoped>

</style>
