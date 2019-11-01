<template>
    <aside>
        <b-field grouped group-multiline>
            <div class="control">
                <b-taglist attached v-if="productModule.product.status" @click="editStatus = $route.meta.editing">
                    <b-tag type="is-dark">Status</b-tag>
                    <b-tag :type="{
                            'is-warning': productModule.product.status === 'aangevraagd',
                            'is-primary': productModule.product.status === 'opgepakt',
                            'is-info': productModule.product.status === 'afgerond',
                        }">{{ productModule.product.status }}</b-tag>
                </b-taglist>
            </div>
            <div class="control">
                <b-taglist attached v-if="productModule.product.soort" @click="edits.kind = $route.meta.editing">
                    <b-tag type="is-dark">Soort</b-tag>
                    <b-tag :type="{
                            'is-primary': productModule.product.soort === 'drukwerk',
                            'is-info': productModule.product.soort === 'digitaal',
                        }">{{ productModule.product.soort }}</b-tag>
                </b-taglist>
            </div>
            <div class="control">
                <b-taglist attached v-if="productModule.product.hours" @click="edits.hours = $route.meta.editing">
                    <b-tag type="is-dark">Uren</b-tag>
                    <b-tag type="is-success">
                        {{ productModule.product.hours.total }}
                    </b-tag>
                </b-taglist>
            </div>
        </b-field>
    
        <!-- Hier de modals om deze aan te passen -->
        <b-modal :active.sync="editStatus" has-modal-card><status-modal></status-modal></b-modal>
    </aside>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator'
    import { productModule, ProductModule } from '../../../../store/product.module'
    import {
        StatusModal
    } from '../edits';

    @Component({
        components: { StatusModal }
    })
    export default class ProductHeaderTabs extends Vue {
        productModule: ProductModule = productModule;
        editStatus: boolean = false;
        
        edits: any = {
            // @ts-ignore $route does exist
            hours: false,
            // @ts-ignore $route does exist
            kind: false,
            // @ts-ignore $route does exist
            status: false
        };
    }
</script>
