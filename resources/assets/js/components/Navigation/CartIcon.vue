<template>
    <button class="dropdown-btn" @click="go">
      <span class="fas fa-shopping-cart" :class="{'font-orange' : count > 0}">&nbsp;<font>{{ count }}</font></span>
    </button>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'count',
    ])
  },
  props: [
    'element'
  ],
  methods: {
    ...mapActions([
      'getCartCount'
    ]),
    go() {
      document.location.href = this.$root.url + '/cart/mycart'
    }
  },
  mounted() {
    if (this.element == 'nav') {
      this.getCartCount()
    }
  }
}
</script>
