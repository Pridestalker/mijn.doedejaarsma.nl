<template>
    <aside>
        <h5>Product opties</h5>
        <section v-if="options.papier">
            papier: {{ options.papier }}
        </section>
        <section v-if="options.gewicht">
            Gewicht: {{ options.gewicht }}
        </section>
        <section v-if="options.oplage">
            Oplage: {{ options.oplage }}
        </section>
        <section v-if="options.afleveradres">
            Afleveradres: {{ options.afleveradres }}
        </section>
    </aside>
</template>

<script>
    export default {
        name: "ProductOptionsComponent",
        props: {
            options: {
                type: Object,
                default: {},
                required: false,
            }
        }
    }
</script>

<style scoped>

</style>
