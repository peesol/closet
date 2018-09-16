<template>
<div class="profile-header-row">
  <label>{{productsCount}}&nbsp;{{ productsCount > 1 ? $trans.translation.products : $trans.translation.product }}</label>
  <label>{{followers}}&nbsp;{{ followers > 1 ? $trans.translation.followers : $trans.translation.follower }}</label>
</div>
</template>

<script>
export default {
  data() {
    return {
      productsCount: null,
      followers: null,
      up: null,
      down: null,
    }
  },
  props: {
    shopSlug: null
  },
  methods: {
    getStats() {
      this.$http.get(this.$root.url + '/' + this.shopSlug + '/status').then(response => {
        this.up = response.body.up;
        this.down = response.body.down;
        this.productsCount = response.body.products;
        this.followers = response.body.follows;
      });
    },

  },

  created() {
    this.getStats();
  }

}
</script>
