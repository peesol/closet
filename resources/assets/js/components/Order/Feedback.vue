<template>
<div class="relative" v-show="!reviewed">
  <vue-progress-bar></vue-progress-bar>
  <div class="panel-heading">
    <h2 class="no-margin font-grey">{{$trans.translation.write_review}}</h2>
  </div>
  <div class="margin-10-top panel-body-res">
    <form class="grey-bg border-radius-5 panel-body">
      <div class="full-width rating">
        <input @click="valueChanged" id="rating5" type="radio" :value="5" v-model="points"></input>
        <label for="rating5"></label>
        <input @click="valueChanged" id="rating4" type="radio" :value="4" v-model="points"></input>
        <label for="rating4"></label>
        <input @click="valueChanged" id="rating3" type="radio" :value="3" v-model="points"></input>
        <label for="rating3"></label>
        <input @click="valueChanged" id="rating2" type="radio" :value="2" v-model="points"></input>
        <label for="rating2"></label>
        <input @click="valueChanged" id="rating1" type="radio" :value="1" v-model="points"></input>
        <label for="rating1"></label>
      </div>
      <div class="form-group">
        <label class="full-label input-label">{{$trans.translation.comment}}</label>
        <textarea @keyup="valueChanged" class="comment-input" rows="5" cols="80" v-model="comment"></textarea>
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
      reviewed: this.status,
    }
  },
  props: [
    'order',
    'status'
  ],
  methods: {
    valueChanged() {
      if (this.points && this.comment) {
        this.$emit('disable', false)
      } else {
        this.$emit('disable', true)
      }
    },
    submit() {
      if (!this.reviewed && this.points && this.comment) {
        this.$Progress.start()
        this.$root.loading = true
        this.$http.post(this.$root.url + '/order/'+ this.order + '/reviews', {
          points: this.points,
          comment: this.comment,
          order_id: this.orderId
        }).then(response => {
          this.points = null
          this.comment = null
          this.$emit('success')
          this.$Progress.finish()
          this.$root.loading = false
          toastr.success(this.$trans.translation.success)
        }, response => {
          this.$Progress.fail()
          this.$root.loading = false
          toastr.error(this.$trans.translation.error)
        });
      }
    },
  }
}
</script>
