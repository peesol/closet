<template>
<div v-on-clickaway="hide" v-show="$root.authenticated">
  <notification-icon element="nav" @clicked="clicked"></notification-icon>
  <cart-nav element="nav"></cart-nav>
  <button class="dropdown-btn" :class="{ 'btn-active' : toggled === 1 }" @click.prevent="toggle(1)"><span class="icon-user"></span></button>
  <div @click.stop v-show="toggled === 1" class="dropdown-content shadow-1">
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
  <div v-show="toggled === 2" class="dropdown-content shadow-1">
    <div class="notification">
      <li v-for="data in notifications">
        {{ data.body }}<br>
        <small>{{ data.created_at }}</small>
      </li>
      <li v-show="!notifications.length" class="align-center">{{ $trans.translation.notification_null }}</li>
    </div>
    <li class="align-center">
      <a class="view-all" :href="$root.url + '/profile/notifications'">{{ $trans.translation.view_all }}</a>
    </li>
  </div>
</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
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
      toggled: null,
      toggledList: null
    }
  },
  computed: {
    ...mapGetters([
      'notifications',
      'notificationsRead'
    ])
  },
  props: {
    userName: null,
    userShop: null,
    logoutRoute: null,
  },
  methods: {
    ...mapActions([
      'markAllAsRead'
    ]),
    logout() {
      this.$http.post(this.logoutRoute).then((response) => {
        window.location.replace(this.$root.url)
      });
    },
    toggle(id) {
      if (this.toggled === id){
        this.toggled = null
        return;
      }
      this.toggled = id
    },
    toggleList(id) {
      if (this.toggledList === id){
        this.toggledList = null
        return;
      }
      this.toggledList = id
    },
    hide() {
      this.toggled = null
    },
    clicked() {
      this.toggle(2)
      if (!this.notificationsRead) {
        this.markAllAsRead()
      }
    }
  }
}
</script>
