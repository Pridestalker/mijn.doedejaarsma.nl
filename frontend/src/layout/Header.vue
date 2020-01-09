<template>
    <v-app-bar app color="white" light>
      <div class="d-flex align-center">
        <v-img
          alt="Doede Jaarsma communicatie B.V."
          :src="require('../assets/logo.png')"
          class="shrink mr-2"
          contain
          transition="scale-transition"
          height="50"
        />
      </div>
      <v-spacer />
    </v-app-bar>
</template>

<script>
export default {
  name: 'Header',
  mounted: {
    init () {
      this.$store.dispatch('user/get_current_user')
    }
  }
}
</script>
