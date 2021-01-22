import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import notification from './modules/notification'
import roles from './modules/role'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    notification,
    roles,
  },
  strict: true
})
