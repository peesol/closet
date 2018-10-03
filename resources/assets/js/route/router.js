import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const SearchResult = require('../components/Search/SearchResult.vue');
const ShopContact = require('../components/Shop/ShopContactEdit.vue');
const ShopEdit = require('../components/Shop/ShopEdit.vue');
const ShopAccount = require('../components/Shop/ShopAccountEdit.vue');
const NotificationSettings = require('../components/Notification/NotificationSettings.vue');
const Showcase = require('../components/Showcase.vue');

const routes = [
  {
    path: '/search/result',
    component: SearchResult
  },
  {
    name: 'profileEdit',
    path: '/settings/profile',
    component: ShopEdit,
    props: true
  },
  {
    name: 'contactEdit',
    path: '/manage/contact',
    component: ShopContact
  },
  {
    name: 'showcaseEdit',
    path: '/manage/showcase',
    component: Showcase
  },
  {
    name: 'accountEdit',
    path: '/manage/account',
    component: ShopAccount
  },
  {
    name: 'notificationSettings',
    path: '/settings/notification',
    component: NotificationSettings
  },
];

export const router = new VueRouter({
  mode: 'history',
  routes
})
