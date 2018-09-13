<template>
<div style="margin-top: 20px;">
  <vue-progress-bar></vue-progress-bar>
  <form v-on:submit.prevent="confirm(uid)" method="post">
    <div class="form-group">
      <label class="col-label" style="width:100%;">{{$trans.translation.name}}</label>
      <input required class="col-input" v-model="name">
    </div>
    <div class="form-group">
      <label class="col-label">{{$trans.translation.delivery_address}}</label>
      <textarea required class="description-input" style="height: 150px;font-size: 1.2em;" v-model="address"></textarea>
    </div>
    <div class="form-group">
      <label class="col-label" style="width:100%;">{{$trans.translation.delivery_phone}}</label>
      <input required class="col-input" v-model="phone">
    </div>
  <div class="flex msg-btn margin-10-top">
    <button :disabled="$root.loading" type="submit">{{$trans.translation.confirm}}</button>
  </div>

  </form>
</div>
</template>

<script>
export default {
  data() {
    return {
      orders: [],
      data: [],
      address: null,
      phone: null,
      name: null
    }
  },
  props: {
    uid: null,
  },
  methods: {
    confirm(uid) {
      this.$Progress.start();
      this.$http.put(this.$root.url + '/order/' + uid + '/confirm', {
        shipping: this.shipping,
        shipping_fee: this.shipping_fee,
      }).then(response => {
        this.shipping = null;
        this.shipping_fee = null;
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish()
        this.$root.loading = false
        document.location.href= this.$root.url + '/order/' + uid + '/confirm';
      }, response => {
        this.$root.loading = false
        toastr.error(this.$trans.translation.error);
      });
    },
    deny(uid) {
      if (!confirm(this.$trans.translation.deny_confirm)) {
        return
      } else {
      this.$Progress.start();
      this.$http.delete(this.$root.url + '/order/' + uid + '/deny').then((response) => {
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish()
        document.location.href= this.$root.url;
      });
      }
    },
  },
}
</script>
<style lang="css">

</style>
