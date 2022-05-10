
const routes = [
  {
    name: 'index',
    path: '/',
    props:{default: true},
    component: require('../../../components/principal/Index.vue').default
  },
  {
    name: 'login',
    path: '/login',
    props:{default: true},
    component: require('../../../components/login/Index.vue').default
  },
  {
    name: 'perfil',
    path: '/perfil',
    props:{default: true},
    component: require('../../../components/principal/perfil/Index.vue').default
  },
  {
    name: 'users',
    path: '/registers/users',
    props:{default: true},
    component: require('../../../components/principal/registers/users/Index.vue').default
  },
  {
    name: 'veedores',
    path: '/registers/veedores',
    props:{default: true},
    component: require('../../../components/principal/registers/veedores/Index.vue').default
  },
  {
    name: 'detalle veedor',
    path: '/veedor/detail/:id',
    props:{default: true},
    component: require('../../../components/principal/veedor/detalle.vue').default
  },
];


export default routes;