<template>
<div v-on-clickaway="hide" class="float-left">
  <button class="menu-btn icon-menu" :class="{ 'btn-active' : toggled }" @click.prevent="toggled = !toggled"></button>
  <div  class="menu-wrapper" v-bind:class="{'toggled' : toggled}">
      <div class="menu">
        <div id="full-line">
          <a href="/"><i class="icon-home"></i>{{ $trans.translation.home }}</a>
          <a href="#"><i class="icon-fire"></i>{{ $trans.translation.trending }}</a>
          <a href="#"><i class="icon-refresh"></i>{{ $trans.translation.used_market }}</a>
          <a href="/category/main" ><i class="icon-category"></i>{{ $trans.translation.categories }}</a>
        </div>
        <div id="full-line">
          <label id="menu-label-grey">{{ $trans.translation.profile }}</label>
          <div v-show="!$root.authenticated">
            <a :href="$root.url + '/login'">{{ $trans.translation.login }}</a>
            <a :href="$root.url + '/register'">{{ $trans.translation.register }}</a>
          </div>
          <div v-show="$root.authenticated">
            <a href="#"><i class="icon-user"></i>{{ $trans.translation.my_profile }}</a>
            <a href="/profile/note"><i class="icon-note"></i>{{ $trans.translation.my_note }}</a>
            <a href="/profile/mycollection"><i class="icon-map"></i>{{ $trans.translation.my_collection }}</a>
            <a href="/profile/following"><i class="icon-star-full"></i>{{ $trans.translation.following }}</a>
            <a href="/profile/order/buying"><i class="icon-order"></i>{{ $trans.translation.buying_orders }}</a>
            <a href="#" @click.prevent="logout()"><i class="icon-exit"></i>{{ $trans.translation.logout }}</a>
          </div>
        </div>
        <div id="full-line">
          <label id="menu-label-grey">{{ $trans.translation.management }}</label>
          <a :class="{'transparent-bg toggled-list' : listToggled}" @click.prevent="listToggled = !listToggled"><i class="icon-plus"></i>{{ $trans.translation.sell }}</a>
          <div v-show="listToggled" id="full-line">
            <a href="/sell/new">{{ $trans.translation.new }}</a>
            <a href="/sell/used">{{ $trans.translation.used }}</a>
          </div>
          <a href="/profile/order/selling"><i class="icon-box"></i>{{ $trans.translation.my_products }}</a>
          <a href="/profile/promotions/manage"><i class="icon-price-tag"></i>{{ $trans.translation.promotions }}</a>
          <a href="/profile/order/selling"><i class="icon-order"></i>{{ $trans.translation.selling_orders }}</a>
          <a :href="$root.url + '/' + userShop + '/edit/general'"><i class="icon-cog"></i>{{ $trans.translation.setting }}</a>
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
      listToggled: null
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
    hide() {this.toggled = false},
  },
}
</script>
