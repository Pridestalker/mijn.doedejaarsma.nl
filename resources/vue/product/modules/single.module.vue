<template>
    <main class="product-single-container">
        <router-link :to="{name: 'index'}">Terug naar het overzicht</router-link>
        <title-component>{{ product.name }}</title-component>
        <small class="text-muted" v-if="product.owner">{{ product.owner.name }} van {{ product.owner.team[0].name }}</small>
        <div v-if="product.description">
            <span>Voor {{ product.name }} is de volgende opmerking gegeven:</span>
            <p>
                {{ product.description }}
            </p>
        </div>
        <div v-if="(userMod.hasRole('admin') || userMod.hasRole('designer'))">
            {{ product.name }} is <span  class="underline hoverable" title="status" :class="product.status" @click="statusChange = !statusChange">{{ product.status }}</span>
            <transition name="fade">
                <form v-if="statusChange" class="d-flex" @submit.prevent="updateStatus">
                    <select class="custom-select" v-model="product.status">
                        <option :value="'aangevraagd'">Aangevraagd</option>
                        <option :value="'opgepakt'">Opgepakt</option>
                        <option :value="'afgerond'">Afgerond</option>
                    </select>
                    <button type="submit" class="btn link">Aanpassen</button>
                </form>
            </transition>
        </div>
        <p v-else>
            {{ product.name }} is <span class="underline" title="status" :class="product.status">{{ product.status }}</span>
        </p>
        <p v-if="product.deadline">
            {{ product.name }} heeft de volgende deadline: <span class="underline date">{{ formattedDate(product.deadline) }}</span>
        </p>
        <div v-if="product.soort = 'drukwerk'">
            <span>Het gaat om een <span class="underline" :class="product.soort">{{ product.soort }}</span> aanvraag</span>
            <ul v-if="product.options">
                <li v-for="(value, option) in JSON.parse(product.options)" :key="option">
                    {{ option }}: {{ value }}
                </li>
            </ul>
        </div>
        <div v-else-if="product.soort = 'digitaal'">
            <span>Het gaat om een <span class="underline" :class="product.soort">{{ product.soort }}</span> aanvraag</span>
        </div>
        <p v-if="product.format">
            "{{ product.format }}" is het gewenste formaat.
        </p>
        <p v-if="product.hours">
            Gemaakte uren: <span class="underline date">{{ formattedTime(product.hours.total) }}</span>
        </p>
        <p v-if="product.attachment">
            <a :href="product.attachment">
                Download voorbeeld
            </a>
        </p>
        <footer>
            <small class="text-muted pointer" v-if="product.updated_at" @click="fetchData" title="Gegevens updaten">Laatste update: {{ formattedUpdate }}</small>
        </footer>
        
        <footer v-if="userMod.hasRole('admin') || userMod.hasRole('designer')" class="timeForm">
            <h5>Uren toevoegen:</h5>
            <add-hours-component :user_id="user.id" :product_id="Number.parseInt(product.id)" v-if="user"></add-hours-component>
        </footer>
    </main>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import { productModule } from '../store/product.module';
import { userModule } from '../store/user.module';
import { format, formatDistance } from 'date-fns';
import { nl } from 'date-fns/locale';
import AddHoursComponent from '../components/AddHoursComponent'
import TitleComponent from '../components/TitleComponent'

@Component( {
    components: { TitleComponent, AddHoursComponent },
} )
export default class SingleModule extends Vue {
    id = null;
    product = {};
    user = null;
    userMod = userModule;
    statusChange = false;
    
    created() {
        this.id = this.$route.params.id;
    }
    
    mounted() {
        this.fetchData();
        this.fetchUser();
    }
    
    async fetchUser() {
        await userModule.loadUser();
        this.user = userModule.user;
    }
    
    async fetchData() {
        productModule.setId(this.id);
        await productModule.loadProduct();
        this.product = productModule.product;
    }
    
    async updateStatus() {
        productModule.setId(this.id);
        productModule.setStatus(this.product.status);
        let res = await productModule.updateStatus();
        this.product = productModule.product;
        this.statusChange = false;
    }
    
    get formattedUpdate() {
        if (!this.product)
            return;
        return formatDistance(new Date(this.product.updated_at.date), new Date(), { addSuffix: true, locale: nl });
    }

    formattedDate(date) {
        return format(new Date(date), 'cccc dd MMMM YYYY', { awareOfUnicodeTokens: true, locale: nl })
    }
    
    formattedTime(time) {
        if (!this.product) {
            return '';
        }
        if (!this.product.hours) {
            return '';
        }
        let decimal = (this.product.hours.total - Math.floor(this.product.hours.total)).toPrecision(2) * 100;
        if (!decimal) {
            return Math.floor(this.product.hours.total)
        }
        return `${Math.floor(this.product.hours.total)}:${(decimal/100 * 60).toPrecision(2)}`
    }
    
}
</script>

<style lang="scss">
    .product-single-container {
        padding: 2rem 4rem;
        border-radius: 14px;
        -webkit-box-shadow: 0 3px 4px rgba(51, 51, 51, 0.2);
        -moz-box-shadow: 0 3px 4px rgba(51, 51, 51, 0.2);
        box-shadow: 0 3px 4px rgba(51, 51, 51, 0.2);
        background: #ffffff;
        position:relative;
        min-height: 500px;
        @media screen and (max-width: 414px) {
            padding: 2rem;
        }
    }
    
    .underline {
        position: relative;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -ms-transition: all 0.4s;
        -o-transition: all 0.4s;
        transition: all 0.4s;
        
        &::after {
            position: absolute;
            bottom: 0;
            left: 0;
            content: ' ';
            width: 100%;
            height: 0.5rem;
        }
        
        &.hoverable:hover {
            cursor: pointer;
            &::after {
                height: 100%;
                -webkit-transition: all 0.4s;
                -moz-transition: all 0.4s;
                -ms-transition: all 0.4s;
                -o-transition: all 0.4s;
                transition: all 0.4s;
            }
        }
        
        &.drukwerk {
            &::after {
                background: rgba(179, 39, 179, 0.2);
            }
        }
        
        &.digitaal {
            &::after {
                background: rgba(132, 51, 83, 0.2);
            }
        }
        
        &.opgepakt {
            &::after {
                background: linear-gradient(to left, rgba(39, 149, 179, 0.2), rgba(10, 10, 180, 0.2));
            }
        }
        
        &.aangevraagd {
            &::after {
                background: linear-gradient(to left, rgba(10, 10, 180, 0.2), rgba(20, 189, 179, 0.2));
            }
        }
        
        &.afgerond {
            &::after {
                height: 100%;
                background: linear-gradient(rgba(79, 179, 58, 0.2), rgba(20, 189, 179, 0.2));
            }
        }
        
        &.date {
            &::after {
                background: rgba(49, 20, 158, 0.2);
            }
        }
    }
    
    .link {
        cursor: pointer;
        position: relative;
        &:hover {
            &::after {
                position: absolute;
                content: ' ';
                top: 0;
                left: 0;
                border-radius: 4px;
                width: 100%;
                height: 100%;
                background-size: 400% 400%;
                padding: 1rem;
                background-image: linear-gradient(to left, rgba(39, 149, 179, 0.2), rgba(10, 10, 180, 0.2), rgba(79, 179, 58, 0.2), rgba(20, 189, 179, 0.2), rgba(179, 39, 179, 0.2), rgba(132, 51, 83, 0.2));
                animation: lightSpeedBackground 1.8s infinite;
            }
        }
    }
    
    @keyframes lightSpeedBackground {
        0% {
            background-position: 0 0;
        }
        25% {
            background-position: 0 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        75% {
            background-position: 50% 0;
        }
        100% {
            background-position: 0 0;
        }
    }
    
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    
    .timeForm {
        margin-top: 3rem;
    }
    
    .pointer {
        cursor: pointer;
    }
</style>
