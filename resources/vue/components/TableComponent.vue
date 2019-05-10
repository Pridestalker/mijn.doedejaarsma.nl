<template>
    <table class="djc-table">
        <thead>
            <slot name="thead"></slot>
        </thead>
        <tbody>
            <slot></slot>
        </tbody>
        <tfoot>
            <slot name="tfoot"></slot>
        </tfoot>
    </table>
</template>

<script>
    export default {
        name: "TableComponent",
    }
</script>

<style scoped lang="scss">
    .djc-table {
        width: 100%;
    }
</style>
