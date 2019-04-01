<template>
    <form @submit.prevent="submitForm" v-if="user_id && product_id">
        <label for="hours">Aantal uren</label>
        <input type="text" v-model="hours" id="hours" name="hours" class="form-control" :class="inputStatus">
        <button type="submit" class="btn btn-outline-primary my-2" :disabled="buttonStatus.disabled">Invoeren</button>
        <small class="d-block text-muted">Let op: Gebruik een punt(.) in plaats van een komma(,)</small>
    </form>
</template>

<script>
import Component from 'vue-class-component/lib/index';
import { Watch } from 'vue-property-decorator';
import Vue from 'vue';

@Component({
    props: {
        user_id: {
            type: Number,
            default: null,
            required: true,
        },
        product_id: {
            type: Number,
            default: null,
            required: true,
        },
    },
})
export default class AddHoursView extends Vue {
    hours = '00.00';
    
    inputStatus = 'is-valid';
    
    buttonStatus = {
        disabled: false
    };
    
    async submitForm() {
        let data = {
            hours: this._turnTimeToFloat(),
            user_id: this.user_id,
            product_id: this.product_id
        }
        
        this.buttonStatus.disabled = 'disabled';
        
        try {
            await this.$http.post('/api/v1/hours/', data);
        } catch (e) {
            console.warn(e)
        }
        
        window.location.reload();
    }
    
    _turnTimeToFloat() {
        const decimalInt = (this.hours - Math.floor(this.hours)).toPrecision(2) * 100
        const decimal = 100 / (60/decimalInt);
        return parseFloat(`${Math.floor(this.hours)}.${decimal}`);
    }
    
    @Watch('hours')
    hoursWatcher(hours, oldHours) {
        let decimal = (hours - Math.floor(hours)).toPrecision(2) * 100
        if (!Number.isInteger(decimal / 15)) {
            this.inputStatus = 'is-invalid';
        } else {
            this.inputStatus = 'is-valid';
        }
    }
}
</script>
