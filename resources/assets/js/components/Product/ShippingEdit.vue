<template>
<div class="padding-30">
  <vue-progress-bar></vue-progress-bar>
  <form @submit.prevent="add" v-show="shippings.length < 5">
    <div class="form-group">
      <label class="input-label" for="shipping">{{$trans.translation.shipping}}</label>
      <input required id="method" :placeholder="$trans.translation.shipping_ex" v-validate="'max:20'" :class="{'form-input': true,'is-error': errors.has('shipping')}" type="text" v-model="form.method">
    </div>
    <div class="input-group flex padding-15-vertical">
      <label for="time" class="input-label padding-15-right">{{$trans.translation.shipping_time}}</label>
      <input required class="width-60 form-input no-margin" min="1" type="number" v-model.number="form.time" id="time">
      <label class="input-label padding-15-left">{{$trans.translation.days}}</label>
    </div>
    <div class="padding-15-vertical">
      <label class="input-label padding-15-right">{{$trans.translation.shipping_free}}</label>
      <input id="yes" type="radio" v-model="form.free" name="shipping_free" :value="1">
      <label for="yes" class="input-label">{{$trans.translation.yes}}</label>
      <input id="no" type="radio" v-model="form.free" name="shipping_free" :value="0">
      <label for="no" class="input-label">{{$trans.translation.no}}</label>
    </div>

    <div class="padding-15-vertical" v-show="form.free === 0">
      <label for="fee" class="input-label padding-15-right">{{$trans.translation.shipping_fee}}</label>
      <input :required="form.free === 0" class="form-input width-60 no-margin" min="1" type="number" v-model.number="form.fee" name="fee">
      <label class="input-label padding-15-left">{{$trans.translation.baht}}</label>
    </div>

    <div class="align-right full-width">
      <button class="orange-btn normal-sq" type="submit">{{$trans.translation.add}}</button>
    </div>
  </form>

  <div class="margin-20-top" v-show="shippings.length">
    <label class="heading">{{$trans.translation.shipping}}</label>
    <div v-for="(item, index) in shippings" class="padding-10" id="full-line">
      <button @click.prevent="remove(index)" class="flat-btn fas fa-trash-alt" v-show="shippings.length > 1"></button>
      {{ item.method }}&nbsp;/&nbsp;{{ item.time }}&nbsp;{{$trans.translation.days}}&nbsp;/&nbsp;{{ item.free ? 'free' : item.fee + '฿' }}
    </div>
    <div class="align-right full-width padding-15-top" v-show="!saved">
      <button :disabled="$root.loading || errors.any()" @click.prevent="save" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
    </div>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      shippings: this.shopShipping,
      form: {
        method: null,
        fee: null,
        time: null,
        free: null,
      },
      saved: true
    }
  },
  props: [ 'shopShipping' ],
  methods: {
    add() {
      this.shippings.push(this.form)
      this.form = {
        method: null,
        fee: null,
        time: null,
        free: null
      }
      this.saved = false
    },
    remove(index) {
      this.shippings.splice(index, 1)
      this.saved = false
    },
    save() {
      this.$Progress.start()
      this.$root.loading = true
      this.$http.put(this.$root.url + '/myproduct/shipping/update', {
        shipping: this.shippings,
      }).then(response => {
        this.$Progress.finish()
        this.$root.loading = false
        toastr.success(this.$trans.translation.saved)
        if (this.$route.path == '/sell/new') {
          document.location.href = this.$root.url + '/sell/new';
        }
      }, response => {
        this.$Progress.fail()
        this.$root.loading = false
        toastr.error(this.$trans.translation.error)
      });
      this.saved = true
    },
  },
  created() {
    if (!this.shopShipping) {
      this.shippings = []
    }
  }
}
</script>
