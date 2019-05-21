<template>
    <component class="underline" :class="classList" :is="tag" :href="link">
        <slot></slot>
    </component>
</template>

<script>
    export default {
        name: "SpanUnderline",
        props: {
            tag: {
                type: String,
                default: 'span',
                validator: (val) => ['span', 'a'].indexOf(val) !== -1
            },
            hover: {
                type: Boolean,
                default: false,
            },
            animated: {
                type: Boolean,
                default: false,
            },
            link: {
                type: String,
                default: null,
            },
            classes: {
                type: Array,
                default: () => []
            },
            type: {
                type: String,
                default: 'default'
            }
        },
        computed: {
            classList() {
                if (this.hover) {
                    this.classes.push('hover-me')
                }

                if (this.animated) {
                    this.classes.push('animated')
                }
                
                this.classes.push(`color--${this.type}`)

                return this.classes.join(' ');
            }
        }
    }
</script>

<style scoped lang="scss">
    
    .underline {
        position: relative;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -ms-transition: all 0.4s;
        -o-transition: all 0.4s;
        transition: all 0.4s;
        
        font-weight: 600;
        
        &::after {
            position: absolute;
            bottom: 0;
            left: 0;
            content: ' ';
            width: 100%;
            height: 0.5rem;
        }
        
        &.hover-me:hover {
            cursor: pointer;
            &::after {
                height: 100%;
                -webkit-transition: all 0.4s;
                -moz-transition: all 0.4s;
                -ms-transition: all 0.4s;
                -o-transition: all 0.4s;
                transition: all 0.4s;
            }
        }
        
        &.color--drukwerk {
            &::after {
                background: rgba(179, 39, 179, 0.2);
            }
        }
        
        &.color--digitaal {
            &::after {
                background: rgba(132, 51, 83, 0.2);
            }
        }
        
        &.color--opgepakt {
            &::after {
                background: linear-gradient(to left, rgba(39, 149, 179, 0.2), rgba(10, 10, 180, 0.2));
            }
        }
        
        &.color--aangevraagd {
            &::after {
                background: linear-gradient(to left, rgba(10, 10, 180, 0.2), rgba(20, 189, 179, 0.2));
            }
        }
        
        &.color--afgerond {
            &::after {
                height: 100%;
                background: linear-gradient(rgba(79, 179, 58, 0.2), rgba(20, 189, 179, 0.2));
            }
        }
        
        &.color--date {
            &::after {
                background-color: rgba(49, 20, 158, 0.2);
            }
        }
    }
</style>
