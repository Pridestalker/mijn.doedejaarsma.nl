<template>
    <div class="form-group">
        <p>
            Soort product
        </p>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" value="digitaal" id="soort[digitaal]" name="soort" class="custom-control-input" v-model="soort" required>
            <label class="custom-control-label" for="soort[digitaal]">Digitaal</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="soort[drukwerk]" name="soort" class="custom-control-input" value="drukwerk" v-model="soort" required>
            <label class="custom-control-label" for="soort[drukwerk]">Drukwerk</label>
        </div>
        
        <div class="form-group" v-show="soort === 'drukwerk'">
            <label for="oplage">Oplage</label>
            <input type="text" name="oplage" id="oplage" class="form-control" v-model="oplage">
            <label for="papier">Soort papier</label>
            <input type="text" name="papier" id="papier" class="form-control" v-model="papier">
            <label for="gewicht">Papier gewicht</label>
            <input type="text" name="gewicht" id="gewicht" class="form-control" v-model="gewicht">
            <label for="afleveradres">Afleveradres</label>
            <input type="text" name="afleveradres" id="afleveradres" class="form-control" v-model="afleveradres">
        </div>
    </div>
</template>

<script>
    export default {
        name: "SoortComponent",
        data() {
            return {
                soort: 'digitaal',
                oplage: '',
                papier: '',
                gewicht: '',
                afleveradres: '',
            }
        },
        mounted() {
            if (localStorage.getItem('product_soort'))
                this.soort = localStorage.getItem('product_soort')
            
            if (localStorage.getItem('product_oplage'))
                this.oplage = localStorage.getItem('product_oplage')
            
            if (localStorage.getItem('product_gewicht'))
                this.gewicht = localStorage.getItem('product_gewicht')
            
            if (localStorage.getItem('product_afleveradres'))
                this.afleveradres = localStorage.getItem('product_afleveradres')
        },
        watch: {
            soort() {
                localStorage.setItem('product_soort', this.soort)
            },
            oplage() {
                localStorage.setItem('product_oplage', this.oplage)
            },
            gewicht() {
                localStorage.setItem('product_gewicht', this.gewicht)
            },
            afleveradres() {
                localStorage.setItem('product_afleveradres', this.afleveradres)
            }
        },
    }
</script>

<style scoped>

</style>
