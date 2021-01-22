import Vue from 'vue'
import VueRouter from 'vue-router'
import jwtToken from '../helper/jwt-token'
// import Meta from 'vue-meta'
import store from '../store/index'
import routes from './routes'
import axios from 'axios'

Vue.use(VueRouter)
// Vue.use(Meta)

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach(async (to, from, next) => {
  // just logged in: localStorage has token, but state does not have auth user
  if (jwtToken.getToken() && !store.getters.isLoggedIn) {
    try {
      let { data: authUser } = await axios.get('/api/user')
      await store.dispatch('setAuthUser', authUser)
    } catch (e) {
      jwtToken.removeToken()
      store.dispatch('unsetAuthUser')
        .then(() => {
          return next({ name: 'login' })
        })
    }
  }

  if (to.meta.requiresAuth) {
    if (store.getters.isLoggedIn || jwtToken.getToken())
      return next()
    else
      return next({ name: 'login' })
  }

  if (to.meta.requiresGuest) {
    if (store.getters.isLoggedIn || jwtToken.getToken())
      return next({ name: 'welcome' })
    else
      return next()
  }

  if (!to.matched.length) {
    next('/404')
  } else {
    next()
  }

  next()
})

export default router
