import axios from 'axios'

export default {
  getLogo() {
    axios.get('/api/logo')
  }
}
