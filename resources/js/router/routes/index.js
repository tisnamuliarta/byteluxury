import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Auth from '@/components/Auth';

Vue.use(Router);

let baseRoutes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/login',
    name: 'auth',
    component: Auth
  },
];

// Import all of the resource routes files.
function loadRoutes() {
  const context = require.context('@/resources', true, /routes.js$/i)
  return context.keys()
    .map(context) // import module
    .map(m => m.default) // get `default` export from each resolved module
}

const resourceRoutes = loadRoutes();
resourceRoutes.forEach((route) => {
  routes.push(route[0]);
});

export default new Router({
  mode: 'history',
  routes,
})
