<template>
    <section>
        <a @click="isActive = !isActive" class="text-primary" href="#" v-show="!isActive">Status aanpassen</a>
        
        <div class="form-group" v-if="isActive">
            <select name="status" id="status">
                <option value="aangevraagd">Aangevraagd</option>
                <option value="opgepakt">Opgepakt</option>
                <option value="afgerond">Afgerond</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Aanpassen</button>
        </div>
    </section>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component
export default class ModifyProductStatus extends Vue {
    isActive = false;
}
</script>
