import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const SearchResult = require('../components/Search/SearchResult.vue');

const routes = [
  {
    path: '/search/result',
    component: SearchResult,
  }
];

export const router = new VueRouter({
  mode: 'history',
  routes
})
//
// window.addEventListener('load', function () {
//     const filter = new Vue({
//       router
//     }).$mount('#app');
// });
