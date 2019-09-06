<template>
    <main>
        <section class="content">
            <h1>
                Welkom bij jouw vernieuwde dashboard<span v-if="userModule.user.name">, {{ userModule.user.name.split(' ')[0] }}</span>
            </h1>
            
            <p>
                Als {{ userModule.roles.join(' & ') }} heb je inkijk in alle functies van
                het <a href="https://doedejaarsma.nl">Doede Jaarsma communicatie</a> DTP systeem.
            </p>
            
            <h2>
                Producten
            </h2>
            <nav class="level">
                <div class="level-item has-text-centered">
                    <div>
                        <div class="heading">Openstaand</div>
                        <div class="title" v-if="userModule.user.projects">{{ userModule.user.projects.aangevraagd.count }}</div>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <div class="heading">Opgepakt</div>
                        <div class="title" v-if="userModule.user.projects">{{ userModule.user.projects.opgepakt.count }}</div>
                    </div>
                </div>
                <div class="level-item has-text-centered">
                    <div>
                        <div class="heading">Afgerond</div>
                        <div class="title" v-if="userModule.user.projects">{{ userModule.user.projects.afgerond.count }}</div>
                    </div>
                </div>
            </nav>
        </section>
    </main>
</template>

<script lang="ts">
    import { Vue, Component } from 'vue-property-decorator';
    import { userModule, UserModule } from '../../store/user.module'

    @Component
    export default class AdminHome extends Vue {
        userModule: UserModule = userModule;
    }
</script>
