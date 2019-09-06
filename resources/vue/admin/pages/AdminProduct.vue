<template>
    <main>
        <section class="content">
            <h1>
                {{ productModule.product.name }}
            </h1>
            <p>
                <small v-if="productModule.product.owner.id">
                    <a :href="'mailto:' + productModule.product.owner.email">
                        {{ productModule.product.owner.name }}
                    </a> van {{ productModule.product.owner.team[0].name}}
                    op {{ formattedDate(productModule.product.created_at) }}
                </small>
            </p>
            <p>
                <b-field grouped group-multiline>
                    <div class="control">
                        <b-taglist attached v-if="productModule.product.status">
                            <b-tag type="is-dark">Status</b-tag>
                            <b-tag :type="{
                            'is-warning': productModule.product.status === 'aangevraagd',
                            'is-primary': productModule.product.status === 'opgepakt',
                            'is-info': productModule.product.status === 'afgerond',
                        }">{{ productModule.product.status }}</b-tag>
                        </b-taglist>
                    </div>
                    <div class="control">
                        <b-taglist attached v-if="productModule.product.status">
                            <b-tag type="is-dark">Soort</b-tag>
                            <b-tag :type="{
                            'is-primary': productModule.product.soort === 'drukwerk',
                            'is-info': productModule.product.soort === 'digitaal',
                        }">{{ productModule.product.soort }}</b-tag>
                        </b-taglist>
                    </div>
                    <div class="control">
                        <b-taglist attached v-if="productModule.product.hours">
                            <b-tag type="is-dark">Uren</b-tag>
                            <b-tag type="is-success">
                                {{ productModule.product.hours.total }}
                            </b-tag>
                        </b-taglist>
                    </div>
                </b-field>
            </p>
        </section>
        
        <section class="content" v-if="productModule.product.deadline">
            <p>
                Deadline: {{ formattedDate(productModule.product.deadline) }}
            </p>
        </section>
        
        <section class="section content" v-if="productModule.product.description">
            {{ productModule.product.description }}

        </section>
        
        <section class="section content" v-if="productModule.product.options">
            <ul>
                <li v-for="(option, key) in JSON.parse(productModule.product.options)" :key="key" v-if="option">
                    {{key}}: {{ option }}
                </li>
            </ul>

        </section>
    
        <footer>
            <small class="text-grey-light">
                Laatste aanpassing op: <span v-if="productModule.product.updated_at">{{ formattedDate(productModule.product.updated_at) }}</span>
            </small>
        </footer>
        <section>
        
        <pre>
    {{ productModule.product }}
        </pre>
        </section>
    </main>
</template>

<script lang="ts">
    import { Vue, Component } from 'vue-property-decorator';
    import { ProductModule, productModule } from '../../store/product.module'
    import { format } from "date-fns"
    import { nl } from "date-fns/locale"
    
    @Component
    export default class AdminProduct extends Vue {
        productModule: ProductModule = productModule;

        formattedDate(date) {
            return format(new Date(date), 'cccc dd MMMM yyyy', { locale: nl })
        }
        
        mounted() {
            // @ts-ignore $route does exist.
            if ((this.$route.params.id as unknown as number) !== (this.productModule.product.id as unknown as number)) {
                // @ts-ignore $route does exist.
                this.productModule.setId(this.$route.params.id as unknown as number);
                this.productModule.loadProduct();
            }
        }
    }
</script>
