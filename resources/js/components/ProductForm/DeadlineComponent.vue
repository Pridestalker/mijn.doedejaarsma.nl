<template>
    <div class="form-group">
        <label for="deadline">Gewenste deadline</label>
        <input type="date" class="form-control" id="deadline" name="deadline" v-model="deadline">
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
            }
        },
    }
</script>

<style scoped>

</style>
