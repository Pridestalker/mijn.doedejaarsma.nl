<template>
    <main>
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="/">
                        DJC DTP
                    </a>
        
                    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </nav>
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
