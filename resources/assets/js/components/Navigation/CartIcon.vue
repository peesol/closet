<template>
    <button class="dropdown-btn" onclick="">
      <span class="icon-cart">&nbsp;{{ count }}</span>
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
  methods: {
    ...mapActions([
      'getCartCount'
    ]),
    go() {
      document.location.href = this.root.url + '/cart/mycart'
    }
  },
  mounted() {
    this.getCartCount()
  }
}
</script>
