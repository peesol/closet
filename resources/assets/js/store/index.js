import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)


const store = new Vuex.Store({
  state: {
    count: 0
  },
  getters: {
    count (state) {
      state.count
    }
  },
  mutations: {
    increment (state) {
      state.count++
    }
  }
})

window.addEventListener('load', function () {
    const cart = new Vue({
      el: '.cart',
      store
    })
});
