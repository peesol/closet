<template>
<div class="dropdown-btn">
    <a :href="cartUrl"><span class="icon-cart"></span></a>
    <label class="font-bold grey-font">{{ count }}</label>
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
