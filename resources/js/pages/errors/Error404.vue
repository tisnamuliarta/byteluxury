<template>
  <main>
    <v-content>
      <v-container fluid>
        <v-layout column align-center>
          <div class="display-3 grey--text mt-5">{{ $t('page_not_found') }}</div>
          <div class="body-2 my-3">
            <router-link :to="{ name: 'index' }">
              {{ $t('go_home') }}
            </router-link>
          </div>
        </v-layout>
      </v-container>
    </v-content>
  </main>
</template>

<script>
export default {
name: "Error404"
}
</script>

<style scoped>

</style>
