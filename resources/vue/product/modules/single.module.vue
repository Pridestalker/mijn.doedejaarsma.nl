<template>
    <card-container class="product-single-container">
        <router-link :to="{name: 'index'}">Terug naar het overzicht</router-link>
        <title-component>{{ product.name }}</title-component>
        <small class="text-muted" v-if="product.owner"><a :href="'mailto:' + this.product.owner.email + '?subject=Opmerkingen ' + this.product.name">{{ product.owner.name }}</a><span v-if="product.owner.team.length > 0"> van {{ product.owner.team[0].name }}</span></small>

        <div v-if="product.description">
            <span>Voor {{ product.name }} is de volgende opmerking gegeven:</span>
            <p>
                {{ product.description }}
            </p>
        </div>

        <div v-if="(userMod.hasRole('admin') || userMod.hasRole('designer'))">
            Status opdracht:
            <span @click="statusChange = !statusChange">
                <span-underline hover :type="product.status">
                    {{product.status}}
                </span-underline>
            </span>
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
			Status opdracht: <span title="status">{{ product.status }}</span>
        </p>

        <p v-if="product.deadline">
            Deadline: <span type="date">{{ formattedDate(product.deadline) }}</span>
        </p>

        <div v-if="product.soort = 'drukwerk'">
            <span>Eigenschappen <span :style="{fontWeight: 'bold'}">{{ product.soort }}</span> aanvraag</span>
            <ul v-if="product.options">
				<li v-if="product.format">Formaat: {{ product.format }}</li>
                <li v-for="(value, option) in getOptions(product.options)" :key="option" v-if="value">
                    {{ option }}: {{ value }}
                </li>
            </ul>
        </div>
        <div v-else-if="product.soort = 'digitaal'">
            <span>Het gaat om een digitale aanvraag</span>
        </div>

        <p v-if="product.hours">
            Gemaakte uren: <span type="date">{{ formattedTime(product.hours.total) }}</span>
        </p>

		<p v-if="product && (product.kostenplaats || product.referentie)">
			<span class="d-block" v-if="product.kostenplaats">Kostenplaats: {{ product.kostenplaats.name }}</span>
			<span class="d-block" v-if="product.referentie">Referentie: {{ product.referentie }}</span>
		</p>

        <p v-if="product.attachment">
            <a :href="'/products/' + product.id + '/image'">
                Download voorbeeld
            </a>
        </p>
        <footer>
            <small class="text-muted pointer" v-if="product.updated_at" @click="fetchData" title="Gegevens updaten">
                Laatste update: {{ formattedUpdate }}
                door {{ updatedBy }}
            </small>
        </footer>

        <footer v-if="userMod.hasRole('admin') || userMod.hasRole('designer')" class="timeForm">
            <h5>Uren toevoegen:</h5>
            <add-hours-component :user_id="user.id" :product_id="Number.parseInt(product.id)" v-if="user" @updated="fetchData" />
        </footer>
    </card-container>
</template>

<script lang="ts" src="./single/Single.ts"></script>

<style src="./single/style.scss" lang="scss" />
