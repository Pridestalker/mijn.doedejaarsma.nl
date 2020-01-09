
export default {
  namespaced: true,
  state: {
    users: []
  },
  mutations: {
    set_users ({ state }, users) {
      state.users = users
    }
  },
  actions: {
    async get_users ({ commit, state }) {
      commit('users/set_users', [])

      return state.users
    }
  },
  getters: {}
}
