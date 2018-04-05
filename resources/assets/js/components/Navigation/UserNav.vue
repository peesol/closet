<template>
<div v-on-clickaway="hide" v-show="$root.authenticated">
  <cart-icon></cart-icon>
  <button class="dropdown-btn" :class="{ 'btn-active' : toggled === 1 }" @click.prevent="toggle(1)">{{ $trans.translation.sell }}</button>
  <div v-show="toggled === 1" class="dropdown-content shadow-1">
    <a :href="$root.url + '/sell/new'">{{ $trans.translation.new }}</a>
    <a :href="$root.url + '/sell/used'">{{ $trans.translation.used }}</a>
  </div>
  <button class="dropdown-btn" :class="{ 'btn-active' : toggled === 2 }" @click.prevent="toggle(2)"><span class="icon-user"></span></button>
  <div @click.stop v-show="toggled === 2" class="dropdown-content shadow-1">
    <div class="dropdown-name">{{userName}}</div>
    <a :href="$root.url + '/' + userShop">{{ $trans.translation.my_profile }}</a>
    <li v-bind:class="{'toggled-list' : toggledList === 1}" @click.prevent="toggleList(1)">{{ $trans.translation.my_products }}&nbsp;<small class="icon-arrow-down"></small></li>
    <transition name="slide-down-height">
      <div v-show="toggledList === 1">
        <a class="nested" :href="$root.url + '/profile/myproduct/new'">{{ $trans.translation.new }}</a>
        <a class="nested" :href="$root.url + '/profile/myproduct/used'">{{ $trans.translation.used }}</a>
      </div>
    </transition>
    <a :href="$root.url + '/' + userShop + '/edit/general'">{{ $trans.translation.setting }}</a>
    <li v-bind:class="{'toggled-list' : toggledList === 2}" @click.prevent="toggleList(2)">{{ $trans.translation.language }}&nbsp;<small class="icon-arrow-down"></small>
    </li>
    <transition name="slide-down-height">
      <div v-show="toggledList === 2">
        <dropdown-language :language="$root.locale"></dropdown-language>
      </div>
    </transition>
    <li @click.prevent="logout()">{{ $trans.translation.logout }}</li>
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
