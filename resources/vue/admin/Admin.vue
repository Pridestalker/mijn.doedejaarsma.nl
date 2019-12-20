<template>
    <main>
        <admin-header></admin-header>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <admin-menu></admin-menu>
                    <div class="column">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';
import AdminHeader from './layout/AdminHeader'
import AdminMenu from './layout/AdminMenu'
import { UserModule, userModule } from '../store/user.module'

@Component({
    components: { AdminHeader, AdminMenu }
})
export default class Admin extends Vue {
    userModule = userModule;
    
    mounted() {
        this.userModule.loadUser();
    }
}
</script>

<style lang="scss">
    @import "~bulma/sass/utilities/functions";
    
    $primary: #ef8716;
    $primary-invert: findColorInvert($primary);
    
    // Links
    $link: $primary;
    $link-invert: $primary-invert;
    $link-focus-border: $primary;

    @import "~bulma";
    @import "~buefy/src/scss/buefy";
</style>
