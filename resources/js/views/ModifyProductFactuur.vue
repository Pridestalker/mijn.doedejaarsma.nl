<template>
    <section>
        <a @click="isActive = !isActive" class="text-primary" href="#" v-show="!isActive">Factuurnummer aanpassen</a>
        
        <div class="form-group" v-if="isActive">
            <label for="factuur">Factuur nummer</label>
            <input type="text" name="factuur" id="factuur" placeholder="Voer hier het factuur nummer van informer in..." class="form-control" />
            <button type="submit" class="btn btn-primary mt-2">Aanpassen</button>
        </div>
    </section>
</template>

<script>
    export default {
        name: "ModifyProductFactuur",
        data() {
            return {
                isActive: false,
            }
        }
    }
</script>

<style scoped>

</style>
