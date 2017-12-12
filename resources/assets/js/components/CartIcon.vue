<template>
  <div>
    <li><a :href="cartUrl"><span class="icon-cart"></span></a> <label style="font-weight: 600; color: #6c6c6c;">{{ count }}</label> </li>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      cartUrl: window.Closet.url + '/cart/mycart',
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
    this.getCartCount();
  }
}
</script>
