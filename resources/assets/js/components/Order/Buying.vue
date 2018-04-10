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
      <td><a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <modal name="open-msg" @before-open="beforeOpen" :clickToClose="false" :scrollable="true" :height="'auto'">
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
          <td class="m-cell">{{item.options.choice ? item.options.choice : '---'}}</td>
          <td class="s-cell">{{item.price}}</td>
          <td class="s-cell">{{item.qty}}</td>
        </tr>
        <tr>
          <td colspan="4">
            <h4 class="no-margin">{{$trans.translation.total_price}}&nbsp;:&nbsp;<span class="font-red">{{data.total}}</span>&nbsp;{{$trans.translation.baht}}</h4></td>
        </tr>
        <tr v-show="data.confirmed && !data.trans">
          <td colspan="4">
            <h4 class="no-margin font-red">{{$trans.translation.wait_transaction}}</h4></td>
        </tr>
        <tr v-show="data.trans && !data.shipped">
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.wait_delivery}}</h4></td>
            <p>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</p>
            <label class="input-label">{{$trans.translation.address}}</label>
            <p>{{ data.address }}</p>
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
    <!-- Transaction Confirm Form -->
    <form v-on:submit.prevent="confirm(data.uid, index)" method="post" v-if="!data.trans && data.confirmed">
      <div class="padding-15-horizontal padding-15-bottom">
        <table class="shipping-table">
          <tr>
            <td>
              <h4 class="no-margin font-grey">{{$trans.translation.payment_date}}</h4></td>
            <td><input required pattern=".{10}" @keyup="cleave" class="form-input date width-120" id="date" type="text" v-model="date" :placeholder="$trans.translation.date_placeholder"></td>
            <td><input required @keyup="cleave" class="form-input width-120" id="time" type="text" v-model="time" placeholder="00 : 00 : 00"></td>
          </tr>
          <tr>
            <td colspan="3">
              <h4 class="no-margin font-grey">{{$trans.translation.name}}</h4></td>
          </tr>
          <tr>
            <td colspan="2"><input class="form-input" type="text" v-model="name"></td>
          </tr>
          <tr>
            <td colspan="3">
              <h4 class="no-margin font-grey">{{$trans.translation.phone}}</h4></td>
          </tr>
          <tr>
            <td colspan="2"><input class="form-input" type="text" v-model="phone"></td>
          </tr>
          <tr>
            <td colspan="3">
              <h4 class="no-margin font-grey">{{$trans.translation.address}}</h4></td>
          </tr>
          <tr>
            <td colspan="3"><textarea rows="4" class="comment-input" v-model="address"></textarea></td>
          </tr>
        </table>
      </div>
      <div class="msg-btn">
        <button class="msg-btn-half" type="submit">{{$trans.translation.confirm}}</button>
        <button class="msg-btn-half" @click.prevent="hide()">{{$trans.translation.close}}</button>
      </div>
    </form>
    <!-- Transaction waiting & Delivered -->
    <div class="msg-btn" v-else>
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>

  </modal>

</div>
</template>

<script>
import Cleave from 'cleave.js'

export default {
  data() {
    return {
      orders: [],
      data: [],
      date: null,
      time: null,
      name: this.userName,
      address: this.userAddress,
      phone: this.userPhone,
      index: null,
    }
  },
  props: {
    userName: null,
    userAddress: null,
    userPhone: null,
  },
  methods: {
    getMessages() {
      this.$http.get(this.$root.url + '/profile/order/buying/get').then((response) => {
        this.orders = response.body.data;
      });
    },
    beforeOpen(event) {
      this.data = event.params.data;
      this.index = event.params.index;
    },
    open(order, index) {
      this.$modal.show('open-msg', {
        data: order,
        index: index,
      });
    },
    hide() {
      this.$modal.hide('open-msg');
      this.date = null;
      this.time = null;
      this.address = null;
      this.name = null;
      this.phone = null;
    },
    confirm(uid, index) {
      this.$Progress.start();
      this.$http.put(this.$root.url + '/profile/order/' + uid + '/transaction', {
        date: this.date,
        time: this.time,
        address: this.address,
        name: this.name,
        phone: this.phone,
      }).then((response) => {
        this.date = null;
        this.time = null;
        this.address = null;
        this.name = null;
        this.phone = null;
        this.$modal.hide('open-msg');
        this.$set(this.orders[index], 'trans', true);
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish();
      });
    },
    cleave() {
      new Cleave('#date', {
        date: true,
        datePattern: ['d', 'm', 'Y']
      })
      new Cleave('#time', {
        delimiter: ' : ',
        blocks: [2, 2, 2],
      })
    },
  },
  created() {
    this.getMessages();
  },
}
</script>
