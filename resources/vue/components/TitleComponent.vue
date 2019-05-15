<template>
    <component :is="tag">
        <slot></slot>
    </component>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component
export default class TitleComponent extends Vue {
    @Prop({ default: 'xlarge' })
    size!: string;
    
    get tag(): string {
        
        switch (this.size) {
            case 'xlarge':
                return 'h1';
            case 'large':
                return 'h2';
            default:
                return 'h1';
                
        }
    }
}
</script>

<style scoped lang="scss">
    .is-highlight {
        background: -webkit-linear-gradient(rgb(10, 10, 180), rgb(20, 189, 179));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
