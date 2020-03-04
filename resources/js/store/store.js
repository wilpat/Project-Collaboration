import Vue from 'vue'
import Vuex from 'vuex'
import user from './modules/user'
import VuexPersist from 'vuex-persist'

Vue.use(Vuex)

// const inFifteenMinutes = new Date(new Date().getTime() + 60 * 1000)
const vuexPersist = new VuexPersist({
  key: 'collab',
  storage: localStorage,
  modules: ['user']
})

export default new Vuex.Store({
  plugins: [vuexPersist.plugin],
  modules: {
    user
  }
})
