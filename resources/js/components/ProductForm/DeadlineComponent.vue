<template>
    <div class="form-group">
        <label for="deadline">Gewenste deadline</label>
        <input type="date" class="form-control" id="deadline" name="deadline" v-model="deadline" aria-describedby="deadlineHelper">
		<small id="deadlineHelper" class="form-text text-muted">
			Het opmaken/drukken van middelen neemt gemiddeld 5-10 werkdagen in beslag.
			Heeft je aanvraag meer haast? Neem dan direct even contact met ons op na het plaatsen van je aanvraag.
		</small>
    </div>
</template>

<script>
    export default {
        name: "DeadlineComponent",
        data() {
            return {
                deadline: ''
            }
        },
        mounted() {
            if (localStorage.getItem('product_deadline'))
                this.deadline = localStorage.getItem('product_deadline')
        },
        watch: {
            deadline() {
                localStorage.setItem('product_deadline', this.deadline)
				this.$emit('updated', this.deadline);
            }
        },
    }
</script>

<style scoped>

</style>
