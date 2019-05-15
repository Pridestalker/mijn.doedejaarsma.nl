<template>
    <card-container>
        <title-component>
            Welkom, {{ user.name }}
        </title-component>
        <small class="text-muted">Het is vandaag {{ today }}</small>
        
        <section v-if="user.projects">
            <p v-if="user.projects.aangevraagd.count > 5">
                Het is vandaag druk met {{ user.projects.aangevraagd.count }} die nog niet zijn opgepakt.
            </p>
            <p v-else-if="user.projects.aangevraagd.count >= 2">
                Het is vandaag redelijk druk met {{ user.projects.aangevraagd.count }} die nog niet zijn opgepakt.
            </p>
            <p v-else-if="user.projects.aangevraagd.count > 0">
                Er is nog maar {{ user.projects.aangevraagd.count }} aanvraag.
            </p>
            <p v-else>
                Er zijn geen aanvragen.
            </p>
        </section>
        
        <section>
            <title-component size="large">Gegevens</title-component>
            <p>
                E-mail: {{ user.email }}
            </p>
        </section>
        
        <section v-if="user.projects">
            <title-component size="large">Aanvragen</title-component>
            <p v-if="user.projects.aangevraagd.count > 1">
                Niks te doen? Probeer dit project anders eens
                <a :href="'/products#/single/' + randomProject.id">
                    {{ randomProject.name }}
                </a>
            </p>
            <p v-else-if="user.projects.aangevraagd.count == 1">
                Niks te doen? Probeer dit project anders eens
                <a :href="'/products#/single/' + user.projects.aangevraagd.data[0].id">
                    {{ user.projects.aangevraagd.data[0].name }}
                </a>
            </p>
        </section>
        
    </card-container>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue'
import CardContainer from '../../../components/CardContainer'
import TitleComponent from '../../../components/TitleComponent'

import { format } from 'date-fns';
import { nl } from 'date-fns/locale';
import { userModule } from '../../../store/user.module'

@Component( {
    components: { TitleComponent, CardContainer },
} )
export default class ProfileModule extends Vue {
    user = {};
    User = userModule;
    
    async mounted() {
        await this.fetchData();
    }
    
    async fetchData() {
        this.user = await this.User.loadUser();
        console.log(this.user);
    }
    
    get today() {
        return format(new Date(), 'cccc dd MMMM YYYY', {awareOfUnicodeTokens: true, locale: nl});
    }
    
    get randomProject() {
        return this.user.projects.aangevraagd.data[Math.floor(Math.random() * this.user.projects.aangevraagd.count)]
    }
}
</script>

<style scoped>

</style>
