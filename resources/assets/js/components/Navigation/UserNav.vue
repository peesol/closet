<template>
<div v-on-clickaway="hide" v-show="$root.authenticated">
  <cart-nav element="nav"></cart-nav>
  <button class="dropdown-btn" :class="{ 'btn-active' : toggled }" @click.prevent="toggled = !toggled"><span class="icon-user"></span></button>
  <div @click.stop v-show="toggled" class="dropdown-content shadow-1">
    <div class="dropdown-name">{{userName}}</div>
    <a :href="$root.url + '/' + userShop">{{ $trans.translation.my_profile }}</a>
    <li v-bind:class="{'toggled-list' : toggledList === 1}" @click.prevent="toggleList(1)">{{ $trans.translation.my_products }}&nbsp;<small class="icon-arrow-down"></small></li>
    <transition name="slide-down-height">
      <div v-show="toggledList === 1">
        <a class="nested" :href="$root.url + '/profile/myproduct/new'">{{ $trans.translation.new }}</a>
        <a class="nested" :href="$root.url + '/profile/myproduct/used'">{{ $trans.translation.used }}</a>
      </div>
    </transition>
    <li v-bind:class="{'toggled-list' : toggledList === 2}" @click.prevent="toggleList(2)">{{ $trans.translation.sell }}&nbsp;<small class="icon-arrow-down"></small></li>
    <transition name="slide-down-height">
    <div v-show="toggledList === 2">
      <a class="nested" :href="$root.url + '/sell/new'">{{ $trans.translation.new }}</a>
      <a class="nested" :href="$root.url + '/sell/used'">{{ $trans.translation.used }}</a>
    </div>
    </transition>
    <a :href="$root.url + '/' + userShop + '/edit/general'">{{ $trans.translation.setting }}</a>
    <li v-bind:class="{'toggled-list' : toggledList === 3}" @click.prevent="toggleList(3)">{{ $trans.translation.language }}&nbsp;<small class="icon-arrow-down"></small>
    </li>
    <transition name="slide-down-height">
      <div v-show="toggledList === 3">
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
    'cart-nav': Cart
  },
  data() {
    return {
      toggled: false,
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
