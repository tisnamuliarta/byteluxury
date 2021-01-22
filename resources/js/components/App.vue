<template>
  <div id="app">
    <component :is="layout">
      <transition name="page" mode="out-in">
        <router-view></router-view>
      </transition>
    </component>
  </div>
</template>

<script>
// Load layout components dynamically.
const default_layout = 'default';
export default {
  name: "App",
  computed: {
    layout() {
      return (this.$route.meta.layout || default_layout) + '-layout'
    }
  }
}
</script>
