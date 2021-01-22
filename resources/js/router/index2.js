import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Auth from '@/components/Auth';

Vue.use(Router);

let baseRoutes = [
  {
    path: '/',
    name: 'index',
    meta: {layout: 'default', requiresAuth: true},
    component: () => import('@pages/Welcome').then(m => m.default || m)
  },

  {
    path: '/home',
    name: 'home',
    component: () => import('@pages/Welcome').then(m => m.default || m),
    'meta': {requiresAuth: true, layout: 'default'}
  },

  {
    path: '/login',
    name: 'login',
    meta: {layout: 'auth', requiresGuest: true},
    component: () => import('@pages/auth/Login').then(m => m.default || m)
  },

  {path: '/404', meta: {layout: 'auth'}, component: () => import('@pages/errors/Error404').then(m => m.default || m)},
  {path: '*', meta: {layout: 'auth'}, component: () => import('@pages/errors/Error404').then(m => m.default || m)}
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
