<template>
<div class="profile-rating" v-show="points !== null">
  <label><i class="fas fa-star"></i>&nbsp;<span>{{ points }}%</span></label>
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
    },
    logView() {
      this.$http.put(this.$root.url + '/' + this.shopSlug + '/views')
    }
  },
  created() {
    this.get()    
  },
  mounted() {
    setTimeout(this.logView, 7000)
  }
}
</script>
