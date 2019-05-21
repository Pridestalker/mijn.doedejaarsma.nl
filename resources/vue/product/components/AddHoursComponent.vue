<template>
    <form @submit.prevent="submitForm" v-if="user_id && product_id">
        <div class="input-group w-100">
            <input type="number" step="1" min="0" v-model="hours" id="hours" name="hours" class="form-control" :class="inputStatus">
            <div class="input-group-prepend input-group-append">
                <div class="input-group-text">:</div>
            </div>
            <input type="number" step="15" min="0" id="minutes" name="minutes" class="form-control" v-model="minutes" :class="inputStatus">
        </div>
        <magic-button type="submit" background="blue" cool :style="{marginTop: '1rem'}" :disabled="buttonStatus.disabled">Invoeren</magic-button>
    </form>
</template>

<script>
import Component from 'vue-class-component/lib/index';
import { Watch } from 'vue-property-decorator';
import Vue from 'vue';
import MagicButton from '../../components/MagicButton'

@Component({
    components: { MagicButton },
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
export default class AddHoursComponent extends Vue {
    hours = 0;
    minutes = 0;
    
    inputStatus = '';
    
    buttonStatus = {
        disabled: false,
        error: false
    };
    
    async submitForm() {
        let data = {
            hours: this._turnTimeToFloat(),
            user_id: this.user_id,
            product_id: this.product_id
        }
        
        this.buttonStatus.disabled = 'disabled';
        
        try {
            await this.$http.post('/api/v1/hours', data);
            this.$emit('updated');
        } catch (e) {
            console.warn(e)
        }
        this.buttonStatus.disabled = false;
    }
    
    _turnTimeToFloat() {
        const decimal = 100 / (60/this.minutes);
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
    
    @Watch('minutes')
    minutesWatcher(minutes, oldMinutes) {
        
        if (!Number.isInteger(parseInt(minutes) / 15)) {
            this.inputStatus = 'is-invalid'
        } else {
            this.inputStatus = 'is-valid'
        }
        
        if (parseInt(minutes) >= 60) {
            this.hours++;
            this.minutes = 0;
        }
    }
}
</script>
