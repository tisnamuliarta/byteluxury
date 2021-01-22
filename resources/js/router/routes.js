export default [
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
]
