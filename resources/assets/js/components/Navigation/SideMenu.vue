<template>
<div v-on-clickaway="hide">
  <div class="side-menu-btn" :class="{ 'open' : toggled }" @click.prevent="toggled = !toggled">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
  </div>
  <div  class="left-side-menu" v-bind:class="{'toggled' : toggled}">
      <div class="sub-left-menu">
        <div id="full-line">
          <a href="/"><i class="icon-home"></i>&nbsp;Home</a>
          <a href="#"><span class="icon-fire"></span>&nbsp;trending</a>
          <a href="#"><span class="icon-shop"></span>&nbsp;Shops</a>
        </div>
        <div id="full-line">
          <label id="alt-cat">account</label>
          <div v-show="!$root.authenticated">
            <a :href="$root.url + '/login'">login</a>
            <a :href="$root.url + '/register'">register</a>
          </div>
          <div v-show="$root.authenticated">
            <a href="#"><span class="icon-user"></span>&nbsp;Mycloset</a>
            <a href="#"><span class="icon-bookmarks"></span>&nbsp;Collection</a>
            <a href="/profile/following"><span class="icon-star-full"></span>&nbsp;following</a>
            <a href="/profile/order/selling"><span class="icon-price-tag"></span>&nbsp;Orders</a>
            <a href="#" @click.prevent="logout()"><span class="icon-exit"></span>&nbsp;Logout</a>
          </div>
        </div>
        <div id="full-line">
          <a id="cat" href="" >Categories</a>
          <a :href="$root.url + '/category/' + key" v-for="(category, key) in categories">{{ category }}</a>
        </div>

          <label id="alt-cat">Language</label>
          <language-select></language-select>

      </div>
  </div>
</div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway'
import Language from '../Language/Language.vue'
import { category } from '../../lang/category.js'
export default {
  mixins: [ clickaway ],
  data() {
    return {
      toggled: false,
      categories: category({locale: this.$root.locale})
    }
  },
  methods: {
    logout() {
      this.$http.post( this.$root.url + '/logout').then((response) => {
        window.location.replace(this.$root.url)
      });
    },
    hide() {this.toggled = false},
  },
}
</script>
