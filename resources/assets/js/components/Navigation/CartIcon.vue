<template>
    <button class="dropdown-btn" :href="cartUrl"><span class="icon-cart">&nbsp;{{ count }}</span></button>
</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      cartUrl: this.$root.url + '/cart/mycart',
    }
  },
  computed: {
    ...mapGetters([
      'count',
    ])
  },
  methods: {
    ...mapActions([
      'getCartCount'
    ]),
  },
  mounted() {
    this.getCartCount()
  }
}
</script>
