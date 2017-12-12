import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const SearchFilter = require('./components/SearchFilter.vue');

const routes = [
  {
    path: '/search/result',
    component: SearchFilter,
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
})

window.addEventListener('load', function () {
    const filter = new Vue({
      router
    }).$mount('.filter');
});
