<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <div v-show="user_status.can_write && !user_status.reviewed">
    <div class="margin-20-bottom">
      <button class="orange-btn normal-sq" @click.prevent="formVisible = !formVisible">{{$trans.translation.write_review}}</button>
    </div>
    <div class="sub-panel shadow-1 margin-20-bottom" v-show="formVisible">
      <div class="full-width rating">
        <input id="rating5" type="radio" value="5" v-model="points"></input>
        <label for="rating5"></label>
        <input id="rating4" type="radio" value="4" v-model="points"></input>
        <label for="rating4"></label>
        <input id="rating3" type="radio" value="3" v-model="points"></input>
        <label for="rating3"></label>
        <input id="rating2" type="radio" value="2" v-model="points"></input>
        <label for="rating2"></label>
        <input id="rating1" type="radio" value="1" v-model="points"></input>
        <label for="rating1"></label>
      </div>
      <div class="form-group">
        <label class="full-label input-label">{{$trans.translation.comment}}</label>
        <textarea class="comment-input" rows="5" cols="80" v-model="comment"></textarea>
      </div>
      <div class="align-right full-width margin-10-top">
        <button class="orange-btn normal-sq" @click.prevent="submit">{{$trans.translation.edit_submit}}</button>
      </div>
    </div>
  </div>

  <div v-if="user_review.length" class="review-wrapper user half-width-res">
    <label class="full-label input-label">{{$trans.translation.user_review}}</label>
    <label class="full-label"><i class="icon-star-full" v-for="star in user_review[0].points"></i>&nbsp;</label>
    <p>{{ user_review[0].comment }}</p>
    <div class="align-right full-width">
      <button class="delete-btn round-btn" @click.prevent="remove(user_review[0].id)">
        <small class="icon-bin"></small>
      </button>
    </div>
  </div>
  <div class="total-rating" v-show="reviews.length">
    <h2><i class="icon-star-full"></i>&nbsp;<span>{{ shop_points }}%</span></h2>
  </div>
  <div class="review-wrapper" v-for="review in reviews" v-show="review.giver_id !== $root.user">
    <label><i class="icon-star-full" v-for="star in review.points"></i></label>
    <a class="text-nowrap">{{ review.shop.data.name }}</a>
    <p>{{ review.comment }}</p>
  </div>



</div>
</template>

<script>
export default {
  data() {
    return {
      formVisible: false,
      reviews: [],
      user_status: {},
      user_review: [],
      shop_points: null,
      points: null,
      comment: null
    }
  },
  props: [
    'shopSlug'
  ],
  methods: {
    getReviews() {
      this.$Progress.start()
      this.$http.get(this.$root.url + '/' + this.shopSlug + '/reviews/get').then((response) => {
        this.reviews = response.body.reviews.data;
        this.user_status = response.body.user_status;
        this.user_review = response.body.user_review;
        this.shop_points = response.body.points;
        this.$Progress.finish()
      });
    },
    submit() {
      this.$Progress.start()
      this.$http.post(this.$root.url + '/' + this.shopSlug + '/reviews', {
        points: this.points,
        comment: this.comment
      }).then((response) => {
        this.user_review.push(response.body)
        this.user_status.reviewed = true
        this.points = null
        this.comment = null
        this.$Progress.finish()
        toastr.success(this.$trans.translation.success)
      }, (response) => {
        this.$Progress.fail()
        toastr.error(this.$trans.translation.error)
      });
    },
    remove(id) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$Progress.start()
      this.$http.delete(this.$root.url + '/' + this.shopSlug + '/reviews/delete/' + id).then((response) => {
        this.user_review = []
        this.user_status.reviewed = false
        this.$Progress.finish()
        toastr.success(this.$trans.translation.success)
      });
    }
  },
  created() {
    this.getReviews()
  }
}
</script>
