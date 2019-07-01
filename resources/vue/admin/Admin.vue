<template>
    <main>
        <nav class="navbar"></nav>
        <div class="container">
            <div class="columns">
                <div class="column is-one-quarter">
                    <aside class="menu">
                        <p class="menu-label">General</p>
                        <ul class="menu-list">
                            <li><a href="/products/">Producten</a></li>
                            <li><a href="/users/">Gebruikers</a></li>
                            <li><a href="/admin/">Administratie</a></li>
                            <li><a href="/teams/">Bedrijven</a></li>
                        </ul>
                    </aside>
                </div>
                <div class="column">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Component from 'vue-class-component';
import Vue from 'vue';

@Component
export default class Admin extends Vue {}
</script>

<style lang="scss">
    @import "~bulma/sass/utilities/_all";
    
    $primary: #ef8716;
    $primary-invert: findColorInvert($primary);

    // Links
    $link: $primary;
    $link-invert: $primary-invert;
    $link-focus-border: $primary;

    @import "~bulma";
    @import "~buefy/src/scss/buefy";
</style>
