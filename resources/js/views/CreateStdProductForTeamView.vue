<template>
	<section>
		<div class="progress mb-2">
			<div class="progress-bar progress-bar-striped" role="progressbar" :style="{ width: progress() }" :aria-valuenow="progress()" aria-valuemin="0" aria-valuemax="100">{{ progress() }}</div>
		</div>
		<div v-show="step === 1">
			<naam-component />

			<div class="form-group">
				<label for="description">Omschrijving</label>
				<textarea id="description" class="form-control" name="description">Dit gaat om een niet gewijzigde aanvraag.</textarea>
			</div>
		</div>
		<div v-show="step === 2">
			<format-component />
		</div>
		<div v-show="step === 3">
			<soort-component />
		</div>
		<div v-show="step === 4">
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
		name: 'CreateStdProductForTeamView',
		components: {
			NaamComponent,
			OmschrijvingComponent,
			FormatComponent,
			KostenplaatsComponent,
			DeadlineComponent,
			SoortComponent,
			FileComponent,
			SubmitComponent,
		},
		data() {
			return {
				step: 1,
				maxStep: 5,
				minStep: 1,
			}
		},
		methods: {
			progress() {
				let width = this.step*100/this.maxStep;
				return `${width}%`;
			},

			nextStep() {
				if (this.step <= this.maxStep) {
					this.step++;
				}
			},

			prevStep() {
				if (this.step > this.minStep) {
					this.step --;
				}
			}
		}
	}
</script>
