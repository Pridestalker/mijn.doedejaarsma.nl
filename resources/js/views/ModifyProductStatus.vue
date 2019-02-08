<template>
    <section>
        <a @click="isActive = !isActive" v-show="!isActive">Status aanpassen</a>
        
        <div class="form-group" v-if="isActive">
            <select name="status" id="status">
                <option value="aangevraagd">Aangevraagd</option>
                <option value="opgepakt">Opgepakt</option>
                <option value="afgerond">Afgerond</option>
            </select>
            <button type="submit" class="btn btn-success">Aanpassen</button>
        </div>
    </section>
</template>

<script>
    export default {
        name: "ModifyProductStatus",
        data() {
            return {
                isActive: false,
            }
        }
    }
</script>

<style scoped>

</style>
