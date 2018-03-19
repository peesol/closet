import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const SearchResult = require('../components/Search/SearchResult.vue');
const ShopContact = require('../components/Shop/ShopContactEdit.vue');
const ShopEdit = require('../components/Shop/ShopEdit.vue');
const ShopAccount = require('../components/Shop/ShopAccountEdit.vue');
const Showcase = require('../components/Showcase.vue');

const routes = [
  {
    path: '/search/result',
    component: SearchResult
  },
  {
    name: 'generalEdit',
    path: '/:shop/edit/general',
    component: ShopEdit,
    props: true
  },
  {
    name: 'contactEdit',
    path: '/:shop/edit/contact',
    component: ShopContact
  },
  {
    name: 'showcaseEdit',
    path: '/:shop/edit/showcase',
    component: Showcase
  },
  {
    name: 'accountEdit',
    path: '/:shop/edit/account',
    component: ShopAccount
  },
];

export const router = new VueRouter({
  mode: 'history',
  routes
})
