<template>
<div class="padding-15-horizontal padding-15-top half-width-res">
  <vue-progress-bar></vue-progress-bar>

    <form v-on:submit.prevent="edit" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label class="full-label input-label margin-10-bottom">{{$trans.translation.shipping}}&nbsp;
          <span class="font-normal">{{$trans.translation.shipping_ex}}</span>
        </label>
        <input v-validate="'max:20'" :class="{'form-input': true,'is-error': errors.has('shipping')}" type="text" v-model="shipping" name="shipping">
      </div>


      <div class="input-group flex padding-15-vertical">
        <label class="input-label padding-15-right">{{$trans.translation.shipping_time}}</label>
        <input class="width-60 form-input no-margin" type="number" v-model="shipping_time" name="shipping_time">
        <label class="input-label padding-15-left">{{$trans.translation.days}}</label>
      </div>

      <div class="padding-15-vertical">
        <label class="input-label padding-15-right">{{$trans.translation.shipping_free}}</label>
        <select class="select-input width-60" name="shipping_free" v-model="shipping_free">
              <option value="1">{{$trans.translation.yes}}</option>
              <option value="0">{{$trans.translation.no}}</option>
        </select>
      </div>

      <div class="padding-15-vertical" v-show="shipping_free == false">
        <label class="input-label padding-15-right">{{$trans.translation.shipping_fee}}</label>
        <input class="form-input width-60 no-margin" type="number" v-model="shipping_fee" name="shipping_fee">
        <label class="input-label padding-15-left">{{$trans.translation.baht}}</label>
      </div>

      <div class="align-right full-label">
        <button class="orange-btn normal-sq" type="submit">{{$trans.translation.edit_submit}}</button>
      </div>


    </form>

</div>
</template>

<script>
export default {
  data() {
    return {
      shipping: this.shippingInfo,
      shipping_fee: this.shippingFee,
      shipping_free: this.shippingFree,
      shipping_time: this.shippingTime,
      shipping_inter: this.shippingInter,
    }
  },
  props: {
    shippingInfo: null,
    shippingFree: null,
    shippingFee: null,
    shippingTime: null,
    shippingInter: null,
    productSlug: null,
  },
  computed: {
    url: function() {
      if (this.productSlug) {
        return this.$root.url + '/product/' + this.productSlug + '/edit/shipping'
      } else {
        return this.$root.url + '/profile/myproduct/shipping/update'
      }
    }
  },
  methods: {
    edit() {
      this.$Progress.start()
      this.$http.put(this.url, {
        shipping: this.shipping,
        shipping_fee: this.shipping_fee,
        shipping_free: this.shipping_free,
        shipping_time: this.shipping_time,
        shipping_inter: 'no',
      }).then((response) => {
        toastr.success(this.$trans.translation.saved)
        this.$Progress.finish()
      }, (response) => {
        toastr.error(this.$trans.translation.error)
        this.$Progress.fail()
      });
    },
  }
}
</script>
