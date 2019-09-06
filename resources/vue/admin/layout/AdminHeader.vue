<template>
    <b-navbar class="is-spaced has-shadow" wrapper-class="container">
        <template slot="brand">
            <b-navbar-item tag="router-link" :to="{ name: 'home' }">
                DJC DTP
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
    export default {
        name: "AdminHeader",
    }
</script>
