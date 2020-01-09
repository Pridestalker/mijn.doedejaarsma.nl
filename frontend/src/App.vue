<template>
  <v-app>
    <Header />
    <v-content>
      <v-container>
        <v-row>
          <v-col cols="4">
            <Menu />
          </v-col>
          <v-col>
            <router-view />
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import Header from './layout/Header'
import Menu from './layout/Menu'
export default {
  name: 'App',

  components: {
    Header, Menu
  },

  data: () => ({
    //
  }),
  mounted () {
    this.$store.dispatch('user/fetch_current_user')
  }
}
</script>
