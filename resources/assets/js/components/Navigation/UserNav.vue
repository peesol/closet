<template>
<div v-on-clickaway="hide" v-show="$root.authenticated">
  <cart-icon></cart-icon>
  <button class="dropdown-btn" :class="{ 'btn-active' : toggled === 1 }" @click.prevent="toggle(1)">Sell</button>
  <div v-show="toggled === 1" class="dropdown-content">
    <a :href="$root.url + '/sell/new'">new</a>
    <a :href="$root.url + '/sell/used'">used</a>
  </div>
  <button class="dropdown-btn" :class="{ 'btn-active' : toggled === 2 }" @click.prevent="toggle(2)"><span class="icon-user"></span></button>
  <div @click.stop v-show="toggled === 2" class="dropdown-content shadow-1">
    <div class="dropdown-name">{{userName}}</div>
    <a :href="$root.url + '/' + userShop">My closet</a>
    <li v-bind:class="{'toggled-list' : toggledList === 1}" @click.prevent="toggleList(1)">My Product&nbsp;<small class="icon-arrow-down"></small></li>
    <transition name="slide-down-height">
      <div v-show="toggledList === 1">
        <a class="nested" :href="$root.url + '/profile/myproduct/new'">news</a>
        <a class="nested" :href="$root.url + '/profile/myproduct/used'">used</a>
      </div>
    </transition>
    <a :href="$root.url + '/' + userShop + '/edit/general'">Closet Edit</a>
    <li v-bind:class="{'toggled-list' : toggledList === 2}" @click.prevent="toggleList(2)">Language&nbsp;<small class="icon-arrow-down"></small>
    </li>
    <transition name="slide-down-height">
      <div v-show="toggledList === 2">
        <dropdown-language :language="$root.locale"></dropdown-language>
      </div>
    </transition>
    <li @click.prevent="logout()">Logout</li>
  </div>
</div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway'
import language from '../Language/DropdownLanguage.vue'
import Cart from './CartIcon.vue'
export default {
  mixins: [ clickaway ],
  components: {
    'cart-icon': Cart
  },
  data() {
    return {
      toggled: null,
      toggledList: null,
    }
  },
  props: {
    userName: null,
    userShop: null,
    logoutRoute: null,
  },
  methods: {
    logout() {
      this.$http.post(this.logoutRoute).then((response) => {
        window.location.replace(this.$root.url)
      });
    },
    toggle(id) {
      if (this.toggled === id){
        this.toggled = null
        this.toggledList = null
        return;
      }
      this.toggled = id
      this.toggledList = null
    },
    toggleList(id) {
      if (this.toggledList === id){
        this.toggledList = null
        return;
      }
      this.toggledList = id
    },
    hide() {this.toggled = null}
  }
}
</script>
