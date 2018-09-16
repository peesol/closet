<template>
<div class="profile-rating" v-show="points !== null">
  <label><i class="icon-star-full"></i>&nbsp;<span>{{ points }}%</span></label>
</div>
</template>

<script>
export default {
  data() {
    return {
      points: null
    }
  },
  props: [
    'shopSlug'
  ],
  methods: {
    get() {
      this.$http.get(this.$root.url + '/' + this.shopSlug + '/reviews/total').then(response => {
        this.points = response.body
      })
    }
  },
  created() {
    this.get()
  }
}
</script>
