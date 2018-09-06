<template>
    <button class="dropdown-btn" @click="go">
      <span class="icon-cart">&nbsp;<font class="show-screen">{{ count }}</font></span>
    </button>
</div>
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
