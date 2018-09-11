
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
// import Slick from 'vue-slick';


import VueTrans from './lang/translate'
Vue.use(VueTrans)

import number from './misc/number-filter'
Vue.use(number)

import VueValidate from 'vee-validate'
Vue.use(VueValidate)

import VueResource from 'vue-resource'
Vue.use(VueResource)

import VModal from 'vue-js-modal'
Vue.use(VModal)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: '#ff8300',
  failedColor: 'red',
  thickness: '5px'
});
Vue.config.devtools = true;
import {store} from './store/store'
import {router} from './route/router'

window.addEventListener('load', function () {
   const vue = new Vue({
     el: '#app',
     data: {
       url: window.Closet.url,
       authenticated: window.Closet.user.authenticated,
       locale: window.Closet.locale,
       user: window.Closet.user.user,
     },
     store,
     router
   })
});

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
})

Vue.component('user-nav', require('./components/Navigation/UserNav.vue'));
Vue.component('side-menu', require('./components/Navigation/SideMenu.vue'));
Vue.component('product-vote', require('./components/Product/ProductVote.vue'));
Vue.component('product-comment', require('./components/Product/ProductComment.vue'));
Vue.component('product-edit', require('./components/Product/ProductEdit.vue'));
Vue.component('product-dropzone', require('./components/Product/ProductDropzone.vue'));
Vue.component('shipping-edit', require('./components/Product/ShippingEdit.vue'));
Vue.component('product-sell', require('./components/Product/ProductSell.vue'));
Vue.component('used-sell', require('./components/Product/ProductSell_used.vue'));
Vue.component('product-stock', require('./components/Product/ProductStock.vue'));
Vue.component('product-choice', require('./components/Product/ProductChoice.vue'));
Vue.component('follow-button', require('./components/Follow.vue'));
Vue.component('add-to-cart', require('./components/Product/AddToCart.vue'));
Vue.component('cart', require('./components/Cart/Cart.vue'));
Vue.component('cart-icon', require('./components/Navigation/CartIcon.vue'));
Vue.component('shop-stats', require('./components/Shop/ShopStats.vue'));
Vue.component('shop-review', require('./components/Shop/ShopReview.vue'));
Vue.component('shop-rating', require('./components/Shop/ShopRating.vue'));
Vue.component('shop-edit', require('./components/Shop/ShopEdit.vue'));
Vue.component('shop-cover-edit', require('./components/Shop/ShopCoverEdit.vue'));
Vue.component('profile-thumbnailnail-edit', require('./components/Shop/ShopThumbnailEdit.vue'));
Vue.component('shop-collection', require('./components/Shop/ShopCollection.vue'));
Vue.component('shop-contact-edit', require('./components/Shop/ShopContactEdit.vue'));
Vue.component('shop-account-edit', require('./components/Shop/ShopAccountEdit.vue'));
Vue.component('shop-user-edit', require('./components/Shop/ShopUserEdit.vue'));
Vue.component('collection-edit', require('./components/Collection/CollectionEdit.vue'));
Vue.component('collection-dropzone', require('./components/Collection/CollectionDropzone.vue'));
Vue.component('collection-product', require('./components/Collection/CollectionProduct.vue'));
Vue.component('collection-product-edit', require('./components/Collection/CollectionProductEdit.vue'));
Vue.component('dropdown-language', require('./components/Language/DropdownLanguage.vue'));
Vue.component('language-select', require('./components/Language/Language.vue'));
Vue.component('showcase', require('./components/Showcase.vue'));
Vue.component('showcase-edit', require('./components/ShowcaseEdit.vue'));
Vue.component('order-selling', require('./components/Order/Selling.vue'));
Vue.component('order-buying', require('./components/Order/Buying.vue'));
Vue.component('order-history', require('./components/Order/History.vue'));
Vue.component('confirm-selling', require('./components/Order/ConfirmSelling.vue'));
Vue.component('confirm-trans', require('./components/Order/ConfirmTrans.vue'));
Vue.component('cant-sell', require('./components/Product/CantSell.vue'));
Vue.component('discount-code', require('./components/Promotion/CodeGenerator.vue'));
Vue.component('product-discount', require('./components/Promotion/Discount.vue'));
Vue.component('vue-slick', require('./components/VueSlick.vue'));
Vue.component('banner-slick', require('./components/BannerSlick.vue'));
Vue.component('search-input', require('./components/Search/SearchInput.vue'));
