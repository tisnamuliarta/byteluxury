import axios from 'axios'
import store from '../store'
import router from '../router'
import jwtToken from '../helper/jwt-token'

axios.interceptors.request.use(config => {
  config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken
  config.headers['X-Requested-With'] = 'XMLHttpRequest'

  if (jwtToken.getToken()) {
    config.headers['Authorization'] = 'Bearer ' + jwtToken.getToken()
  }
  // VueProgressBar.$Progress.start(); // for every request start the progress
  return config
}, error => {
  return Promise.reject(error)
})

axios.interceptors.response.use(response => {
  // VueProgressBar.$Progress.finish(); // finish when a response is received
  return response
}, error => {
  let errorResponseData = error.response.data
  const errors = ['token_invalid', 'token_expired', 'token_not_provided', 'Token has expired']
  const message = ['Token has expired']

  if (errorResponseData.error && errors.includes(errorResponseData.error) || message.includes(errorResponseData.message)) {
    store.dispatch('unsetAuthUser')
      .then(() => {
        jwtToken.removeToken()
        router.push({name: 'login'})
      })
  }

  return Promise.reject(error)
})
