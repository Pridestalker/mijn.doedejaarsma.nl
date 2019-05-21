<template>
    <component class="magic-button" :class="classList" :is="tag">
        <slot></slot>
    </component>
</template>

<script>
    export default {
        name: "MagicButton",
        props: {
            tag: {
                type: String,
                default: 'button',
                validator: (val) => ['button', 'a', 'span'].indexOf(val) !== -1
            },
            cool: {
                type: Boolean,
                default: false,
            },
            animated: {
                type: Boolean,
                default: true,
            },
            link: {
                type: String,
                default: null,
            },
            classes: {
                type: Array,
                default: () => []
            },
            background: {
                type: String,
                default: 'purple',
                validator: (val) => ['purple', 'green', 'blue', 'pink', 'salmon', 'ocean', 'white'].indexOf(val) !== -1
            }
        },
        
        computed: {
            classList() {
                this.classes.push(`background--${this.background}`)
                this.classes.push(`border--${this.background}`)
                
                if (this.animated) {
                    this.classes.push('animated')
                }
                if (this.cool) {
                    this.classes.push('cool')
                }
                
                return this.classes.join(' ')
            }
        }
        
    }
</script>

<style scoped lang="scss">
    $colors: (
            'purple': #31149e,
            'green': #4fb33a,
            'blue': #14bdb3,
            'pink': #b327b3,
            'salmon': #843353,
            'ocean': #2795b3,
            'white': #FFFFFF,
    );
    
    $directions: (
        'top', 'bottom', 'left', 'right'
    );
    
    .magic-button {
        @extend %reset-Button;
        
        padding: 6px 10px;
        border-radius: 5px;
        box-shadow: 0 3px 4px rgba(51, 51, 51, 0.2);
        &:hover {
            box-shadow: none;
        }
        
        
        @each $name, $color in $colors {
            &.outline {
                border-width: 1px;
                border-style: solid;
                &.border--#{$name} {
                    border-color: $color;
                }
            }
            
            &:not(.outline) {
                
                &:not(.cool).background--#{$name} {
                    background: $color;
                    @if(lightness($color) > 50%) {
                        color: #333333;
                    } @else {
                        color: #ffffff;
                    }
                }
                
                &.cool.background--#{$name} {
                    background-size: 400%;
                    
                    background-image: linear-gradient(to right, $color, mix(complement($color), invert($color)));
                    background-position: 40% 75%;
                    @if(lightness($color) > 50%) {
                        color: #333333;
                    } @else {
                        color: #ffffff;
                    }
                    
                    &.animated {
                        &:hover {
                            background-position: 10% 75%;
                        }
                    }
                }
            }
        }
        
        transition: all 225ms cubic-bezier(0.0,0.2,1.0,0.4);
    }

    %reset-Button {
        border: none;
        margin: 0;
        width: auto;
        overflow: visible;
    
        background: transparent;
    
        /* inherit font & color from ancestor */
        color: inherit;
        font: inherit;
    
        /* Normalize `line-height`. Cannot be changed from `normal` in Firefox 4+. */
        line-height: normal;
    
        /* Corrects font smoothing for webkit */
        -webkit-font-smoothing: inherit;
        -moz-osx-font-smoothing: inherit;
    
        /* Corrects inability to style clickable `input` types in iOS */
        -webkit-appearance: none;
        /* Remove excess padding and border in Firefox 4+ */
        &::-moz-focus-inner {
            border: 0;
            padding: 0;
        }
    }




</style>
