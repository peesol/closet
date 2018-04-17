<template>
<div class="">
  <vue-progress-bar></vue-progress-bar>
  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.pending_order}}</th>
    </tr>
    <tr v-for="(order, index) in orders" v-show="!order.confirmed">
      <td><a class="link-text overflow-hidden" @click.prevent="open(order, index)">{{order.title}}</a></td>
      <td><span class="float-right">{{order.created_at}}</span></td>
    </tr>
  </table>

  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.wait_transaction}}</th>
    </tr>
    <tr v-for="(item, index) in orders" v-show="item.confirmed && !item.trans">
      <td><a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.transacted}}</th>
    </tr>
    <tr v-for="(item, index) in orders" v-show="item.trans && !item.shipped">
      <td><a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.shipped}}</th>
    </tr>
    <tr v-for="(item, index) in orders" v-show="item.shipped">
      <td><a class="link-text"  @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <modal name="open-msg" @before-open="beforeOpen" :clickToClose="false" :height="'auto'" :adaptive="true">
    <div class="panel-heading">
      <h4 class="no-margin">{{ data.title }}</h4>
    </div>
    <div class="panel-body">
      <table class="c-table" style="margin:0;">
        <tr>
          <th class="overflow-hidden">{{$trans.translation.product_name}}</th>
          <th>{{$trans.translation.choice}}</th>
          <th>{{$trans.translation.price}}</th>
          <th>{{$trans.translation.amount}}</th>
        </tr>
        <tr v-for="item in data.body">
          <td class="overflow-hidden">{{item.name}}</td>
          <td class="m-cell">{{item.options.choice ? item.options.choice :  '---'}}</td>
          <td class="s-cell">{{item.price}}</td>
          <td class="s-cell">{{item.qty}}</td>
        </tr>
        <tr>
          <td colspan="4"><h4 class="no-margin">{{$trans.translation.total_price}}&nbsp;:&nbsp;<span style="color:red;">{{data.total}}</span>&nbsp;{{$trans.translation.baht}}</h4></td>
        </tr>
        <tr v-show="data.confirmed && !data.trans">
          <td colspan="4"><h4 class="no-margin font-red">{{$trans.translation.wait_transaction}}</h4></td>
        </tr>
        <tr v-show="data.trans && !data.shipped">
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.completed_transaction}}</h4>
            <h4>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</h4>
            <label class="input-label">{{$trans.translation.address}}</label>
            <p>{{ data.address }}</p>
          </td>
        </tr>
        <tr v-show="data.shipped">
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.delivered}}</h4>
            <p>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</p>
            <p>{{$trans.translation.track_info}}&nbsp;{{data.carrier}}</p>
            <p>{{$trans.translation.track_number}}&nbsp;{{data.tracking_number}}</p>
            <label class="input-label">{{$trans.translation.address}}</label>
            <p>{{ data.address }}</p>
          </td>
        </tr>
      </table>
    </div>
    <!-- Confirm form -->
      <form v-on:submit.prevent="confirm(data.uid, index)" method="post" v-show="!data.confirmed">
        <div class="padding-15-horizontal padding-15-bottom">
          <table class="shipping-table">
            <tr>
              <td colspan="2"><h4 class="no-margin font-grey">{{$trans.translation.shipping_free}}</h4></td>
              <td colspan="2">
                  <select required class="select-input" v-model="shipping">
                    <option :value="true" selected>{{$trans.translation.yes}}</option>
                    <option :value="false">{{$trans.translation.no}}</option>
                  </select>
              </td>
            </tr>
            <tr v-show="shipping !== null && !shipping">
              <td colspan="1"><h4 class="no-margin font-grey">{{$trans.translation.shipping_fee}}</h4></td>
              <td colspan="1"><input v-bind:required="!shipping" class="form-input" type="number" v-model="shipping_fee"></td>
            </tr>
          </table>
        </div>
        <div class="msg-btn">
          <button type="submit">{{$trans.translation.confirm}}</button>
          <button @click.prevent="deny(data.uid, index)">{{$trans.translation.deny}}</button>
          <button v-bind:class="{'msg-btn-full' : data.confirmed}" @click.prevent="hide()">{{$trans.translation.close}}</button>
        </div>
      </form>

    <!-- Transaction waiting & Delivered -->
    <div class="msg-btn" v-show="data.confirmed && !data.trans || data.shipped">
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>
    <!-- Shipped form -->
      <form v-on:submit.prevent="confirmShipping(data.uid, index)" method="post" v-show="data.trans && !data.shipped">
        <div class="padding-15-horizontal padding-15-bottom">
          <table class="shipping-table">
            <tr>
              <td colspan="1"><h4 class="no-margin font-grey">{{$trans.translation.track_info}}</h4></td>
              <td colspan="2"><input class="form-input" type="text" v-model="track_info"></td>
            </tr>
            <tr>
              <td colspan="1"><h4 class="no-margin font-grey">{{$trans.translation.track_number}}</h4></td>
              <td colspan="2"><input class="form-input" type="text" v-model="tracking_number"></td>
            </tr>
          </table>
        </div>
        <div class="msg-btn">
          <button class="msg-btn-half" type="submit">{{$trans.translation.confirm}}</button>
          <button class="msg-btn-half" @click.prevent="hide()">{{$trans.translation.close}}</button>
        </div>
      </form>

  </modal>

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
      tracking_number: null,
      track_info: null,
      index: null,
      translate: this.$trans
    }
  },
  methods: {
    getMessages() {
      this.$http.get(this.$root.url + '/profile/order/selling/get').then((response)=> {
         this.orders = response.body.data;
       });
    },
    beforeOpen (event) {
        this.data = event.params.data;
        this.index = event.params.index;
    },
    open(order, index) {
      this.$modal.show('open-msg', { data: order, index: index,});
    },
    hide() {
      this.$modal.hide('open-msg');
      this.shipping = null;
      this.shipping_fee = null;
      this.track_info = null;
      this.track_number = null;
    },
    confirm(uid, index) {
      this.$Progress.start();
      this.$http.put(this.$root.url + '/profile/order/' + uid + '/confirm', {
        shipping: this.shipping,
        shipping_fee: this.shipping_fee,
      }).then((response) => {
        this.shipping = null;
        this.shipping_fee = null;
        this.$modal.hide('open-msg');
        this.$set(this.orders[index], 'confirmed', true);
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish();
      });
    },
    deny(uid, index) {
      if (!confirm(this.$trans.translation.deny_confirm)) {
        return
      } else {
      this.$Progress.start();
      this.$http.delete(this.$root.url + '/profile/order/' + uid + '/deny').then((response) => {
        this.$modal.hide('open-msg');
        this.$delete(this.orders, index);
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish()
      });
      }
    },
    confirmShipping(uid, index){
      this.$Progress.start();
      this.$http.put(this.$root.url + '/profile/order/' + uid + '/confirm_shipping', {
        carrier: this.track_info,
        tracking_number: this.tracking_number,
      }).then((response) => {
        this.track_info = null;
        this.track_number = null;
        this.$modal.hide('open-msg');
        this.$set(this.orders[index], 'shipped', true);
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish();
      });
    }

  },

  created() {
    this.getMessages();
  }
}
</script>
