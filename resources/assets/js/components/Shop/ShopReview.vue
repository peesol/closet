<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <div v-for="data in user_review" class="review-wrapper user half-width-res">
    <label class="full-label input-label">{{$trans.translation.user_review}}</label>
    <label class="full-label"><i class="fas fa-star" v-for="star in data.points"></i>&nbsp;</label>
    <p>{{ data.comment }}</p>
    <div class="not-display align-right full-width">
      <button class="flat-btn delete" @click.prevent="remove(data.id)">
        <i class="fas fa-star"></i>
      </button>
    </div>
  </div>
  <div class="total-rating" v-show="reviews.length">
    <h2><i class="fas fa-star"></i>&nbsp;<span>{{ shop_points }}%</span></h2>
  </div>
  <div class="review-wrapper" v-for="review in reviews" v-show="review.giver_id !== $root.user">
    <label><i class="fas fa-star" v-for="star in review.points"></i></label>
    <a class="text-nowrap">{{ review.shop.data.name }}</a>
    <p>{{ review.comment }}</p>
  </div>
  <div v-show="!reviews.length" class="align-center">
    <h2 class="font-grey">{{$trans.translation.no_reviews}}</h2>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      formVisible: false,
      reviews: [],
      user_review: [],
      shop_points: null,
    }
  },
  props: [
    'shopSlug'
  ],
  methods: {
    getReviews() {
      this.$Progress.start()
      this.$root.loading = true
      this.$http.get(this.$root.url + '/' + this.shopSlug + '/reviews/get').then(response => {
        this.reviews = response.body.reviews.data;
        this.user_review = response.body.user_review;
        this.shop_points = response.body.points;
        this.$Progress.finish()
        this.$root.loading = false
      });
    }
  },
  created() {
    this.getReviews()
  }
}
</script>
