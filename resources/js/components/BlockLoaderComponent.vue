<template>
    <div class="loading" :class="size"></div>
</template>

<script>
    export default {
        name: "BlockLoaderComponent",
        props: {
            size: {
                type: String,
                default: 'normal'
            }
        }
    }
</script>

<style scoped>
@keyframes placeholderShimmer {
    0% {
        background-position: -468px 0
    }
    100% {
        background-position: 468px 0
    }
}

.loading {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeholderShimmer;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: linear-gradient(to right, #ef8716 8%, #422506 18%, #ef8716 33%);
    background-size: 800px 104px;
    position: relative;
}

.loading.normal {
    height: 96px;
}

.loading.small {
    height: 40px;
}

.loading.xsmall {
    height: 1rem;
}

.loading.large {
    height: 15rem;
}
</style>
