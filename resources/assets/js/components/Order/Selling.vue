<template>
<div class="">
  <vue-progress-bar></vue-progress-bar>

  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.wait_transaction}}&nbsp;<span class="number" :class="{'not-empty' : added.ordered > 0}">{{ added.ordered }}</span></th>
    </tr>
    <tr v-for="(item, index) in orders" v-show="!item.trans">
      <td><a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.transacted}}&nbsp;<span class="number" :class="{'not-empty' : added.trans > 0}">{{ added.trans }}</span></th>
    </tr>
    <tr v-for="(item, index) in orders" v-show="item.trans && !item.shipped">
      <td><a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <table class="c-table">
    <tr>
      <th colspan="2">{{$trans.translation.shipped}}&nbsp;<span class="number" :class="{'not-empty' : added.shipped > 0}">{{ added.shipped }}</span></th>
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
      <table class="c-table">
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
        <tr v-for="item in data.shipping">
          <td colspan="4">
            {{$trans.translation.shipping_fee}}&nbsp;:&nbsp;{{ item.free ? 'free' : item.fee + '฿' }}&nbsp;({{ item.method + ' ' + item.time + ' ' + $trans.translation.days}})
          </td>
        </tr>
        <tr>
          <td colspan="4"><h4 class="no-margin">{{$trans.translation.total_price}}&nbsp;:&nbsp;<span class="font-red">{{data.total}}</span>&nbsp;฿</h4></td>
        </tr>
        <tr>
          <td colspan="4">
            <label class="input-label">{{$trans.translation.address}}</label>
            <p>{{ data.address }}</p>
          </td>
        </tr>
        <tr v-show="!data.trans">
          <td colspan="4"><h4 class="no-margin font-red">{{$trans.translation.wait_transaction}}</h4></td>
        </tr>
        <tr v-show="data.trans && !data.shipped">
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.completed_transaction}}</h4>
            <h4>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</h4>
          </td>
        </tr>
        <tr v-show="data.shipped">
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.delivered}}</h4>
            <p>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</p>
            <p>{{$trans.translation.track_info}}&nbsp;{{data.carrier}}</p>
            <p>{{$trans.translation.track_number}}&nbsp;{{data.tracking_number}}</p>
          </td>
        </tr>
        <tr v-show="!data.shipped">
          <td colspan="4">
            <button class="delete-btn normal-sq red-box" @click.prevent="deny_form = !deny_form">{{$trans.translation.deny}}</button>
            <form class="align-right" v-show="deny_form" @submit.prevent="deny(data.uid, index)">
              <input required type="text" class="margin-10-vertical full-width" :placeholder="$trans.translation.deny_reason" v-model="deny_reason">
              <button type="submit" class="delete-btn normal-sq red-box">{{$trans.translation.confirm}}</button>
            </form>
          </td>
        </tr>
      </table>
    </div>

    <!-- Transaction waiting & Delivered -->
    <div class="msg-btn" v-show="!data.trans || data.shipped">
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>
    <!-- Shipped form -->
      <form v-on:submit.prevent="confirmShipping(data.uid, index)" method="post" v-show="data.trans && !data.shipped">
        <div class="padding-15-horizontal padding-15-bottom">
          <table class="shipping-table">
            <tr>
              <td colspan="1"><h4 class="no-margin font-grey">{{$trans.translation.track_info}}</h4></td>
              <td colspan="2"><input required class="form-input" type="text" v-model="track_info"></td>
            </tr>
            <tr>
              <td colspan="1"><h4 class="no-margin font-grey">{{$trans.translation.track_number}}</h4></td>
              <td colspan="2"><input class="form-input" type="text" v-model="tracking_number"></td>
            </tr>
          </table>
        </div>
        <div class="msg-btn">
          <button :disabled="$root.loading" class="msg-btn-half" type="submit">{{$trans.translation.confirm}}</button>
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
      tracking_number: null,
      track_info: null,
      index: null,
      deny_form: false,
      deny_reason: null,
      translate: this.$trans
    }
  },
  computed: {
    added: function () {
      var ordered = 0;
      var trans = 0;
      var shipped = 0;
      this.orders.forEach(function (item) {
        if(item.trans) { trans++; }
        if(!item.trans) { ordered++; }
        if(item.shipped) { shipped++; }
      });
      return { trans, ordered, shipped};
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
      this.track_info = null;
      this.track_number = null;
      this.deny_reason = null;
      this.deny_form = false;
    },
    confirmShipping(uid, index){
      this.$Progress.start();
      this.$root.loading = true
      this.$http.put(this.$root.url + '/profile/order/' + uid + '/confirm_shipping', {
        carrier: this.track_info,
        tracking_number: this.tracking_number,
      }).then(response => {
        this.track_info = null;
        this.track_number = null;
        this.$modal.hide('open-msg');
        this.$set(this.orders[index], 'shipped', true);
        this.$Progress.finish();
        this.$root.loading = false
        toastr.success(this.$trans.translation.success);
      }, response => {
        this.$Progress.fail();
        this.$root.loading = false
        toastr.error(this.$trans.translation.error);
      });
    },
    deny(uid, index) {
      if (!confirm(this.$trans.translation.deny + '?')) {
        return
      } else {
        this.$http.put(this.$root.url + '/order/' + uid + '/deny', {
          reason: this.deny_reason,
          type: 1
        }).then(response => {
          this.deny_reason = null;
          this.deny_form = false;
          this.$modal.hide('open-msg');
          this.$delete(this.orders, index);
          toastr.success(this.$trans.translation.success);
          this.$Progress.finish();
        });
      }
    }
  },

  created() {
    this.getMessages();
  }
}
</script>
