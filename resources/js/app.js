import Vue from "vue";

require('./plugins/vuetify')
require('./plugins/axios')

import store from './store'
import router from './router'
import App from './components/App'
import Axios from 'axios'

Vue.prototype.$http = Axios;

import './components'

new Vue({
  store,
  router,
  ...App
}).$mount('#app')
