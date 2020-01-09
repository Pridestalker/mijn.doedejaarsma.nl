import axios from '../../plugins/axios'

export default {
  namespaced: true,
  state: {
    current_user: {},
    current_roles: [],
    users: []
  },
  mutations: {
    set_user (state, user, isCurrent = false) {
      if (isCurrent) {
        state.current_user = user
      }

      state.users.push(user.id, user)
    },

    set_current_roles (state) {
      if (Object.keys(state.current_user).length !== 0) {
        state.current_roles = state.current_user.role
      }
    }
  },
  actions: {
    async fetch_current_user ({ commit, state }) {
      if (Object.keys(state.current_user).length === 0) {
        const currentUser = await axios.get('/api/v1/user/whoami').data

        commit('user/set_user', currentUser, true)
      }

      return state.current_user
    }
  },
  getters: {
    roleById: state => (id) => state.current_roles[id]
  }
}
