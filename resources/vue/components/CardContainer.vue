<template>
    <section class="djc-card">
        <slot></slot>
    </section>
</template>

<script>
    // TODO: Refactor to be more concise
    
    export default {
        name: "CardContainer",
    }
</script>

<style scoped lang="scss">
    .djc-card {
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
</style>
