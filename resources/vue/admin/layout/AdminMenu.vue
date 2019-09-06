<template>
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label">General</p>
            <ul class="menu-list">
                <li><router-link :to="{ name: 'products' }">Producten</router-link></li>
                <li><a class="is-disabled" href="#">Gebruikers</a></li>
                <li><router-link :to="{name: 'administration'}">Administratie</router-link></li>
                <li><a class="is-disabled" href="#">Bedrijven</a></li>
            </ul>
        </aside>
    </div>
</template>

<script>
    export default {
        name: "AdminMenu",
    }
</script>
