<template>
<div v-show="!reviewed">
  <vue-progress-bar></vue-progress-bar>
  <div>
    <button class="orange-btn normal-sq full-width" @click.prevent="getShop(shopId)">{{$trans.translation.write_review}}</button>
  </div>
  <div class="grey-bg border-radius-5 panel-body margin-10-top" v-show="formVisible">
    <form>
      <div class="full-width rating">
        <input id="rating5" type="radio" :value="5" v-model="points"></input>
        <label for="rating5"></label>
        <input id="rating4" type="radio" :value="4" v-model="points"></input>
        <label for="rating4"></label>
        <input id="rating3" type="radio" :value="3" v-model="points"></input>
        <label for="rating3"></label>
        <input id="rating2" type="radio" :value="2" v-model="points"></input>
        <label for="rating2"></label>
        <input id="rating1" type="radio" :value="1" v-model="points"></input>
        <label for="rating1"></label>
      </div>
      <div class="form-group">
        <label class="full-label input-label">{{$trans.translation.comment}}</label>
        <textarea  required class="comment-input" rows="5" cols="80" v-model="comment"></textarea>
      </div>
      <div v-show="shop !== null" class="align-right full-width margin-10-top">
        <button class="orange-btn normal-sq" @click.prevent="submit">{{$trans.translation.edit_submit}}</button>
      </div>
    </form>
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
      shop_points: null,
      points: null,
      comment: null,
      shop: null,
      reviewed: this.$parent.$parent.data.feedback
    }
  },
  props: [
    'shopId',
    'orderId'
  ],
  methods: {
    getShop() {
      this.shop = null
      if (!this.formVisible) {
        this.formVisible = true
        this.$http.get(this.$root.url + '/api/getter/shop/' + this.shopId).then((response) => {
          this.shop = response.body
        })
      } else {
        this.formVisible = false
      }
    },
    submit() {
      if (!this.reviewed) {
        this.$Progress.start()
        this.$http.post(this.$root.url + '/'+ this.shop.slug + '/reviews', {
          points: this.points,
          comment: this.comment,
          order_id: this.orderId
        }).then((response) => {
          this.points = null
          this.comment = null
          this.$emit('submit')
          this.$Progress.finish()
          toastr.success(this.$trans.translation.success)
        }, (response) => {
          this.$Progress.fail()
          toastr.error(this.$trans.translation.error)
        });
      }
    },
  }
}
</script>
