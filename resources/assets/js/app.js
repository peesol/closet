
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Laravel = { csrfToken: $('meta[name=csrf-token]').attr("content") };

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 window.addEventListener('load', function () {
   var language = new Vue({
     el: '.left-side-menu'
   });
});
import Trans from './lang/translate'
Vue.use(Trans);

import VueValidate from 'vee-validate'
Vue.use(VueValidate)

import VueResource from 'vue-resource'
Vue.use(VueResource)

import Vuex from 'vuex'
Vue.use(Vuex)

import VModal from 'vue-js-modal'
Vue.use(VModal)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: '#ff8300',
  failedColor: 'red',
  thickness: '5px'
});

import router from './router'

const mutations = require('./store/mutations');
const actions = require('./store/actions');
const getters = require('./store/getters');
const store = new Vuex.Store({
  mutations,
  actions,
  getters,
  state: {
    cart: [],
    count: null,
    checkout: []
  },
})
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});
window.addEventListener('load', function () {

  const details = new Vue({
    el: '.product-details',
    store
  });
  const cart = new Vue({
    el: '.cart',
    store
  });
  const mycart = new Vue({
    el: '.cart-wrap',
    store
  });
});

Vue.component('product-vote', require('./components/Product/ProductVote.vue'));
Vue.component('product-comment', require('./components/Product/ProductComment.vue'));
Vue.component('product-edit', require('./components/Product/ProductEdit.vue'));
Vue.component('product-dropzone', require('./components/Product/ProductDropzone.vue'));
Vue.component('product-shipping', require('./components/Product/ProductShipping.vue'));
Vue.component('product-sell', require('./components/Product/ProductSell.vue'));
Vue.component('used-sell', require('./components/Product/ProductSell_used.vue'));
Vue.component('used-comment', require('./components/Product/ProductComment_used.vue'));
Vue.component('product-stock', require('./components/Product/ProductStock.vue'));
Vue.component('product-choice', require('./components/Product/ProductChoice.vue'));
Vue.component('follow-button', require('./components/Follow.vue'));
Vue.component('add-to-cart', require('./components/Product/AddToCart.vue'));
Vue.component('cart-icon', require('./components/CartIcon.vue'));
Vue.component('cart', require('./components/Cart/Cart.vue'));
Vue.component('shop-stats', require('./components/Shop/ShopStats.vue'));
Vue.component('shop-vote', require('./components/Shop/ShopVote.vue'));
Vue.component('shop-edit', require('./components/Shop/ShopEdit.vue'));
Vue.component('shop-cover-edit', require('./components/Shop/ShopCoverEdit.vue'));
Vue.component('shop-thumbnail-edit', require('./components/Shop/ShopThumbnailEdit.vue'));
Vue.component('shop-collection', require('./components/Shop/ShopCollection.vue'));
Vue.component('shop-contact-edit', require('./components/Shop/ShopContactEdit.vue'));
Vue.component('shop-account-edit', require('./components/Shop/ShopAccountEdit.vue'));
Vue.component('shop-user-edit', require('./components/Shop/ShopUserEdit.vue'));
Vue.component('collection-edit', require('./components/Collection/CollectionEdit.vue'));
Vue.component('collection-dropzone', require('./components/Collection/CollectionDropzone.vue'));
Vue.component('collection-product', require('./components/Collection/CollectionProduct.vue'));
Vue.component('collection-product-edit', require('./components/Collection/CollectionProductEdit.vue'));
Vue.component('collection-product-show', require('./components/Collection/CollectionProductShow.vue'));
Vue.component('language-select', require('./components/Language.vue'));
Vue.component('showcase', require('./components/Showcase.vue'));
Vue.component('showcase-edit', require('./components/ShowcaseEdit.vue'));
Vue.component('shipping-edit', require('./components/ShippingEdit.vue'));
Vue.component('order-selling', require('./components/Order/Selling.vue'));
Vue.component('order-buying', require('./components/Order/Buying.vue'));
Vue.component('confirm-selling', require('./components/Order/ConfirmSelling.vue'));
Vue.component('confirm-trans', require('./components/Order/ConfirmTrans.vue'));
Vue.component('cant-sell', require('./components/Product/CantSell.vue'));
Vue.component('discount-code', require('./components/Promotion/CodeGenerator.vue'));
Vue.component('product-discount', require('./components/Promotion/Discount.vue'));
