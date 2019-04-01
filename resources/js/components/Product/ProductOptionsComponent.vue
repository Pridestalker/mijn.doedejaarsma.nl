<template>
    <aside>
        <h5 class="my-2">Product opties</h5>
        <section v-if="options.papier">
            Papier: {{ options.papier }}
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
import Component from 'vue-class-component';
import Vue from 'vue';

@Component({
    props: {
        options: {
            type: Object,
            default: {},
            required: false
        }
    }
})
export default class ProductOptionsComponent extends Vue {}
</script>
