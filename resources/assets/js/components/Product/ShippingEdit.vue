<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <div class="panel-heading">
    <label class="heading">{{$trans.translation.shipping_days}}</label>
  </div>

    <div  id="full-line" class="panel-body">
      <div class="check-list margin-10-bottom">
        <button v-for="(day, index) in $trans.translation.sevendays" :class="{'checked' : shipping_date.includes(parseInt(index))}" @click="pickDay(parseInt(index)), daySaved = false">{{day}}</button>
      </div>
      <div class="full-width">
        <button class="help-btn padding-10 margin-10-right" @click="pickDay(8), daySaved = false">{{$trans.translation.weekday}}</button>
        <button class="help-btn padding-10" @click="pickDay(9), daySaved = false">{{$trans.translation.everyday}}</button>
      </div>
      <div v-show="!daySaved && view !== 'cant_sell'" class="align-right full-width">
        <button class="orange-btn normal-sq" @click.prevent="save()">{{$trans.translation.edit_submit}}</button>
      </div>
    </div>

  <div id="full-line" v-show="shipping_methods.length < 4">
    <div class="panel-heading">
      <label class="heading" for="shipping">{{$trans.translation.shipping_methodss_add}}</label>
    </div>
    <form class="panel-body" @submit.prevent="add">
      <div class="form-group">
        <label class="input-label full-width">{{$trans.translation.shipping}}</label>
        <input required id="method" :placeholder="$trans.translation.shipping_ex" v-validate="'max:20'" :class="{'form-input': true,'is-error': errors.has('shipping')}" type="text" v-model="form.method">
      </div>
      <div class="input-group flex padding-15-vertical">
        <label for="time" class="input-label padding-15-right">{{$trans.translation.shipping_time}}</label>
        <input required class="width-60 form-input no-margin" min="1" type="number" v-model.number="form.time" id="time">
        <label class="input-label padding-15-left">{{$trans.translation.days}}</label>
      </div>
      <div class="padding-15-vertical">
        <label class="input-label padding-15-right">{{$trans.translation.shipping_free}}</label>
        <input required @click="form.multiply = null, form.multiply_by = null, form.fee = null" id="yes" type="radio" v-model="form.free" name="shipping_free" :value="true">
        <label for="yes" class="input-label">{{$trans.translation.yes}}</label>
        <input id="no" type="radio" v-model="form.free" name="shipping_free" :value="false">
        <label for="no" class="input-label">{{$trans.translation.no}}</label>
      </div>
      <div v-show="form.free === false">
        <div class="padding-15-vertical">
          <label for="fee" class="input-label padding-15-right">{{$trans.translation.shipping_fee}}</label>
          <input :required="!form.free" class="form-input width-60 no-margin" min="1" type="number" v-model.number="form.fee" name="fee">
          <label class="input-label padding-15-left">{{$trans.translation.baht}}</label>
        </div>
        <div class="padding-15-vertical">
          <label class="input-label padding-15-right">{{$trans.translation.shipping_multiply}}</label>
          <input :required="!form.free" id="yes2" type="radio" v-model="form.multiply" name="multiply" :value="true">
          <label for="yes2" class="input-label">{{$trans.translation.yes}}</label>
          <input id="no2" type="radio" v-model="form.multiply" name="multiply" :value="false">
          <label for="no2" class="input-label">{{$trans.translation.no}}</label>
        </div>
      </div>

      <div class="padding-15-vertical" v-show="form.multiply === true && form.free === false">
        <i class="fas fa-plus font-grey margin-10-right"></i>
        <input :required="form.multiply" class="form-input width-60 no-margin" min="1" type="number" v-model.number="form.multiply_by" name="multiply">
        <label class="input-label padding-15-left">{{$trans.translation.baht}}&nbsp;{{$trans.translation.multiply_by}}</label>
      </div>

      <div class="align-right full-width">
        <button class="orange-btn normal-sq" type="submit">{{$trans.translation.add}}</button>
      </div>
    </form>
  </div>

  <div v-show="shipping_methods.length">
    <div class="panel-heading">
      <label class="heading">{{$trans.translation.shipping}}</label>
    </div>
    <div v-for="(item, index) in shipping_methods" class="padding-10" id="full-line">
      <button @click.prevent="remove(index)" class="flat-btn fas fa-trash-alt" v-show="shipping_methods.length > 1"></button>
      {{ item.method }}&nbsp;/&nbsp;{{ item.time }}&nbsp;{{$trans.translation.days}}&nbsp;/&nbsp;{{ item.free ? 'free' : item.fee + '฿' }}&nbsp;{{ item.multiply ? '+' + item.multiply_by + ' ' + $trans.translation.multiply_by : ''}}
    </div>
    <div class="align-right full-width panel-body" v-show="!saved">
      <button :disabled="$root.loading || errors.any()" @click.prevent="save" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
    </div>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      shipping_date: this.days,
      shipping_methods: this.shipping,
      toggled: null,
      form: {
        method: null,
        fee: null,
        time: null,
        free: null,
        multiply: null,
        multiply_by: null,
      },
      saved: true,
      daySaved: true
    }
  },
  props: [ 'shipping', 'days', 'view'],

  methods: {
    add() {
      this.shipping_methods.push(this.form)
      this.form = {
        method: null,
        fee: null,
        time: null,
        free: null,
        multiply: null
      }
      this.saved = false
    },
    remove(index) {
      this.shippings.splice(index, 1)
      this.saved = false
    },
    save() {
      if (!this.shipping_date.length) {
        alert('โปรดเลือกวันในการจัดส่งสินค้า')
      } else {
        this.$Progress.start()
        this.$root.loading = true
        this.$http.put(this.$root.url + '/myproduct/shipping/update', {
          days: this.shipping_date.sort(),
          methods: this.shipping_methods
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
        if (!this.daySaved) {
          this.daySaved = true
        }
        if (!this.saved) {
          this.saved = true
        }
      }
    },
    pickDay(day) {
      if (day <= 6) {
        if (this.shipping_date.includes(day)) {
          var index = this.shipping_date.indexOf(day);
          this.shipping_date.splice(index, 1);
        } else {
          this.shipping_date.push(day)
        }
      } else if (day === 8) {
        this.shipping_date = []
        this.shipping_date.push(0,1,2,3,4)
      } else if (day === 9) {
        this.shipping_date = []
        this.shipping_date.push(0,1,2,3,4,5,6)
      }
    }
  },
  created() {
    // if (!this.shopShipping.length) {
    //   this.shipping_date = this.shopShipping.days
    //   this.shipping_methods = this.shopShipping.methods
    // }
  }
}
</script>
