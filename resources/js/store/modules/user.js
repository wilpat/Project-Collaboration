const state = {
    user: {},
    is_auth: false,
    error: ''
  }
  
  const mutations = {
    'SET_USER' (state, user) {
      state.user = user
      state.is_auth = true
    },
    'LOGOUT_USER' (state) {
      state.user = {}
      state.is_auth = false
    },
    'setUserError' (state, message) {
      state.error = message
    },
    'clearUserError' (state) {
      state.error = ''
    }
  }
  
  const actions = {
    addUser: ({commit}, user) => {
      commit('SET_USER', user)
    },
    logoutUser: ({commit}) => {
      commit('LOGOUT_USER')
    },
    addUserError: ({commit}, message) => {
      commit('setUserError', message)
    },
    clearUserError: ({commit}) => {
      commit('clearUserError')
    }
  }
  
  const getters = {
    user: state => state.user,
    userError: state => state.error
  }
  
  export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
  }
  