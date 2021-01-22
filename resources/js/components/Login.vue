<template>
  <div class="row justify-content-center">
    <div class="col-md-5 pt-150 pt-6">
      <div class="card bg-secondary shadow border-0">
        <div class="card-header">
          <div class="bg-white border-0">
            <div class="row">
              <div class="col-3">
                <img :src="logo" class="" height="36" alt="E-KB">
              </div>
              <div class="col-9" style="margin-left: -15px;">
                <h2 class="mb-0">Login</h2>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="alert alert-danger" role="alert" v-if="error">
            <strong>Error!</strong> {{ error }}
          </div>
          <form method="POST" @submit.prevent="login">
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">User Code</label>
              <div class="col-md-7">
                <input id="email" type="text" class="form-control form-control-alternative" name="U_UserCode" v-model="form.U_UserCode"
                       required autofocus placeholder="User Code">
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

              <div class="col-md-7">
                <input id="password" type="password" class="form-control form-control-alternative " v-model="form.U_Password"
                       name="U_Password" placeholder="Password"
                       required autocomplete="current-password">
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button id="login" type="submit" class="btn btn-success">
                  Login
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: "Login",
  data: () => ({
    error: null,
    logo: null,
    form: {
      U_Password: null,
      U_UserCode: null
    }
  }),

  created() {
    this.getLogo()
  },

  methods: {
    async getLogo() {
      let response = await axios.get(`/api/logo`)
      this.logo = response.data
      console.log(this.logo)
    },
    login() {
      let vm = this
      axios.post(`/login`, {
        U_UserCode: vm.form.U_UserCode,
        U_Password: vm.form.U_Password,
      })
        .then(res => {
          this.error = null
          if (!res.data.error) {
            window.location = res.data.url
          }
        })
        .catch(err => {
          this.error = err.response.data.message
        })
    }
  }
}
</script>

<style scoped>

</style>
