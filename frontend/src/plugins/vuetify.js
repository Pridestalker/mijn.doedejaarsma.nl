import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import nl from 'vuetify/es5/locale/nl'

Vue.use(Vuetify)

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: '#fe941e',
        secondary: '#424242',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107'
      }
    }
  },
  lang: {
    locales: { nl },
    current: 'nl'
  }
})
