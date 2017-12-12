<template>
<div style="margin-top: 20px;">
  <vue-progress-bar></vue-progress-bar>

  <form v-on:submit.prevent="confirm(uid)">
  <table class="shipping-table">
    <tr>
      <td><h4 class="no-margin grey-font">{{$trans.translation.shipping_free}}</h4></td>
      <td>
          <select required class="select-input" v-model="shipping">
            <option :value="true" selected>{{$trans.translation.yes}}</option>
            <option :value="false">{{$trans.translation.no}}</option>
          </select>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr v-show="shipping !== null && !shipping">
      <td colspan="1"><h4 class="no-margin grey-font">{{$trans.translation.shipping_fee}}</h4></td>
      <td colspan="1"><input v-bind:required="!shipping" class="form-input shipping-fee" type="text" v-model="shipping_fee"></td>
    </tr>
  </table>

  <div class="msg-btn" style="margin-top:30px;">
    <button class="msg-btn-half" type="submit">{{$trans.translation.confirm}}</button>
    <button class="msg-btn-half" @click.prevent="deny(uid)">{{$trans.translation.deny}}</button>
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
      shipping: null,
      shipping_fee: null,
      index: null,
      translate: this.$trans,
      url: window.Closet.url,
      trans: this.$trans.translate(this.locale),
    }
  },
  props: {
    uid: null,
    locale: null,
  },
  methods: {
    confirm(uid) {
      this.$Progress.start();
      this.$http.put(this.url + '/order/' + uid + '/confirm', {
        shipping: this.shipping,
        shipping_fee: this.shipping_fee,
      }).then((response) => {
        this.shipping = null;
        this.shipping_fee = null;
        this.$Progress.finish()
        document.location.href= this.url + '/order/' + uid + '/confirm';
      });
    },
    deny(uid) {
      if (!confirm(this.$trans.translation.deny_confirm)) {
        return
      } else {
      this.$Progress.start();
      this.$http.delete(this.url + '/order/' + uid + '/deny').then((response) => {
        this.$Progress.finish();
        document.location.href= this.url;
      });
      }
    },
  },

}
</script>
