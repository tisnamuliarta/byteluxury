require('./plugins/vuetify')
require('./plugins/axios')

import 'handsontable/dist/handsontable.full.css'

import store from './store'
import router from './router'
import App from './components/App'
import Axios from 'axios'

Vue.prototype.$http = Axios;

import './components'

new Vue({
  store,
  i18n,
  router,
  ...App
}).$mount('#app')
