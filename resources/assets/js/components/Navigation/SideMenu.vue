<template>
<div v-on-clickaway="hide" class="menu-btn-wrap">
  <button class="menu-btn fas fa-bars" :class="{ 'btn-active' : toggled }" @click.prevent="toggled = !toggled"></button>
  <div  class="menu-wrapper" v-bind:class="{'toggled' : toggled}">
      <div class="menu">
        <div id="full-line">
          <a href="/"><i class="fas fa-home"></i>{{ $trans.translation.home }}</a>
          <a href="/trending"><i class="fas fa-fire"></i>{{ $trans.translation.trending }}</a>
          <a href="/secondhand"><i class="fas fa-redo-alt"></i>{{ $trans.translation.used_market }}</a>
          <a href="/category/main" ><i class="fas fa-th-large"></i>{{ $trans.translation.categories }}</a>
          <a href="/help/home" ><i class="fas fa-question-circle"></i>{{ $trans.translation.help }}</a>
        </div>
        <div id="full-line">
          <label id="menu-label-grey">{{ $trans.translation.profile }}</label>
          <div v-show="!$root.authenticated">
            <a :href="$root.url + '/login'">{{ $trans.translation.login }}</a>
            <a :href="$root.url + '/register'">{{ $trans.translation.register }}</a>
          </div>
          <div v-show="$root.authenticated">
            <a :href="'/' + userShop"><i class="fas fa-user"></i>{{ $trans.translation.my_profile }}</a>
            <a href="/profile/note"><i class="fas fa-book"></i>{{ $trans.translation.my_note }}</a>
            <a href="/mycollection"><i class="fas fa-map"></i>{{ $trans.translation.my_collection }}</a>
            <a href="/following"><i class="fas fa-star"></i>{{ $trans.translation.following }}</a>
            <a href="/order/buying"><i class="fas fa-list-ul"></i>{{ $trans.translation.buying_orders }}</a>
            <a :href="$root.url + '/settings/profile'"><i class="fas fa-cog"></i>{{ $trans.translation.setting }}</a>
            <a href="#" @click.prevent="logout()"><i class="fas fa-sign-out-alt"></i>{{ $trans.translation.logout }}</a>
          </div>
        </div>
        <div id="full-line" v-show="$root.authenticated">
          <label id="menu-label-grey">{{ $trans.translation.management }}</label>
          <a :class="{'transparent-bg toggled-list' : toggledList === 2}" @click="window.location.href = $root.url + '/myproduct/new'"><i class="fas fa-plus"></i>{{ $trans.translation.sell }}</a>
          <!-- <div v-show="toggledList === 2" id="full-line">
            <a href="/sell/new">{{ $trans.translation.new }}</a>
            <a href="/sell/used">{{ $trans.translation.used }}</a>
          </div> -->
          <a :class="{'transparent-bg toggled-list' : toggledList === 3}" @click="window.location.href = $root.url + '/sell/new'"><i class="fas fa-archive"></i>{{ $trans.translation.my_products }}</a>
          <!-- <div v-show="toggledList === 3" id="full-line">
            <a href="/myproduct/new">{{ $trans.translation.new }}</a>
            <a href="/myproduct/used">{{ $trans.translation.used }}</a>
          </div> -->
          <a href="/promotions"><i class="fas fa-tag"></i>{{ $trans.translation.promotions }}</a>
          <a href="/manage"><i class="fas fa-briefcase"></i>{{ $trans.translation.manage }}</a>
          <a href="/order/selling"><i class="fas fa-list-ul"></i>{{ $trans.translation.selling_orders }}</a>
        </div>

          <label id="menu-label-grey">{{ $trans.translation.language }}</label>
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
      toggledList: null
    }
  },
  props: [
    'userShop'
  ],
  methods: {
    logout() {
      this.$http.post( this.$root.url + '/logout').then((response) => {
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
    hide() {this.toggled = false},
  },
}
</script>
