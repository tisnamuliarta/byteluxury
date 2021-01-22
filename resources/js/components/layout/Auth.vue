<template>
  <v-app class="bgAuth">
    <v-content>
      <v-container transition="slide-x-transition" fluid fill-height>
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: 'Auth',
}
</script>

<style scoped>
.bgAuth {
  background-image: url('/imgs/bg1.jpg')!important;
  background-repeat: no-repeat!important;
  background-size: cover!important;
}
</style>
