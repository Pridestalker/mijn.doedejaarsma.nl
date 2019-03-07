<template>
    <section>
        <div class="progress mb-2">
            <div class="progress-bar progress-bar-striped" role="progressbar" :style="{ width: progress }" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">{{ progress }}</div>
        </div>
        <div v-show="step === 1">
            <naam-component />
            <omschrijving-component />
        </div>
        <div v-show="step === 2">
            <format-component />
            <deadline-component />
        </div>
        <div v-show="step === 3">
            <kostenplaats-component />
        </div>
        <div v-show="step === 4">
            <soort-component />
        </div>
        <div v-show="step === 5">
            <file-component />
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-outline-primary" v-if="step !== minStep"  @click="prevStep">&lt;</button>
            <button type="button" class="btn btn-outline-primary ml-auto" v-if="step !== maxStep" @click="nextStep">&gt;</button>
            <submit-component v-if="step === maxStep" />
        </div>
    </section>
</template>

<script>
import NaamComponent from '../components/ProductForm/NaamComponent'
import OmschrijvingComponent from '../components/ProductForm/OmschrijvingComponent'
import FormatComponent from '../components/ProductForm/FormatComponent'
import KostenplaatsComponent from '../components/ProductForm/KostenplaatsComponent'
import DeadlineComponent from '../components/ProductForm/DeadlineComponent'
import SoortComponent from '../components/ProductForm/SoortComponent'
import FileComponent from '../components/ProductForm/FileComponent'
import SubmitComponent from '../components/ProductForm/SubmitComponent'
export default {
    name: "CreateProductView",
    components: { SubmitComponent, FileComponent, SoortComponent, DeadlineComponent, KostenplaatsComponent, FormatComponent, OmschrijvingComponent, NaamComponent },
    data() {
        return {
            step: 1,
            maxStep: 5,
            minStep: 1,
        }
    },
    computed: {
        progress()  {
            let width = this.step*100/this.maxStep;
            return `${width}%`;
        }
    },
    methods: {
        nextStep() {
            if (this.step <= this.maxStep) {
                this.step++
            }
        },
        prevStep() {
            if (this.step > this.minStep) {
                this.step--
            }
        }
    }
}
</script>

<style scoped>

</style>
