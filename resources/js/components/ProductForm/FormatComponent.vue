<template>
    <div class="form-group">
        <label for="format">Formaat</label>
        <input type="text" class="form-control" id="format" name="format" aria-describedby="formatHelp" placeholder="Formaat van de opdracht..." v-model="format">
        <small id="formatHelp" class="form-text text-muted">Voer hier het gewenste formaat in, zoals A4 of A5</small>
    </div>
</template>

<script>
    export default {
        name: "FormatComponent",
        data() {
            return {
                format: ''
            }
        },
        mounted() {
            if (localStorage.getItem('product_format'))
                this.format = localStorage.getItem('product_format')
        },
        watch: {
            format() {
                localStorage.setItem('product_format', this.format)
            }
        },
    }
</script>

<style scoped>

</style>
