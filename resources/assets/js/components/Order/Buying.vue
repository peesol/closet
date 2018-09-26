<template>
<div class="relative">
  <vue-progress-bar></vue-progress-bar>
  <load-overlay bg="white-bg" :show="!loaded"></load-overlay>

  <div id="full-line" class="padding-10 full-width lightgrey-bg">
    <a class="flat-btn" :class="{'font-orange font-15em' : tab === 1}" @click="toggleTab(1)">{{$trans.translation.wait_transaction}}&nbsp;
      <span class="number font-medium" :class="{'not-empty' : added.ordered > 0}">{{ added.ordered }}</span>
    </a>
  </div>
  <div id="full-line" v-for="(item, index) in orders" class="col-2-flex-res padding-5" v-show="tab === 1 && !item.trans">
    <div class="text-row">
      <a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a>
    </div>
    <div class="text-row align-right-res">
      {{item.created_at}}
    </div>
  </div>
  <div id="full-line" class="padding-10 full-width lightgrey-bg">
    <a class="flat-btn" @click="toggleTab(2)" :class="{'font-orange font-15em' : tab === 2}">{{$trans.translation.transacted}}&nbsp;
      <span class="number font-medium" :class="{'not-empty' : added.trans > 0}">{{ added.trans }}</span>
    </a>
  </div>
  <div id="full-line" v-for="(item, index) in orders" class="col-2-flex-res padding-5" v-show="tab === 2 && item.trans && !item.shipped">
    <div class="text-row">
      <a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a>
    </div>
    <div class="text-row align-right-res">
      {{item.created_at}}
    </div>
  </div>
  <div id="full-line" class="padding-10 full-width lightgrey-bg">
    <a class="flat-btn" @click="toggleTab(3)" :class="{'font-orange font-15em' : tab === 3}">{{$trans.translation.shipped}}&nbsp;
      <span class="number font-medium" :class="{'not-empty' : added.shipped > 0}">{{ added.shipped }}</span>
    </a>
  </div>
  <div id="full-line" v-for="(item, index) in orders" class="col-2-flex-res padding-5" v-show="tab === 3 && item.shipped">
    <div class="text-row">
      <a class="link-text" @click.prevent="open(item, index)">{{item.title}}</a>
    </div>
    <div class="text-row align-right-res">
      {{item.created_at}}
    </div>
  </div>

  <modal>
    <div slot="body" class="relative">
      <load-overlay bg="white-bg" :show="$root.loading" padding="70px 0"></load-overlay>
      <div class="panel-heading">
        <h4 class="no-margin">{{ data.title }}</h4>
        <sub>#{{ data.uid }}</sub>
      </div>
      <div id="full-line" class="padding-10">
        <span class="red-box padding-5" v-show="!data.trans">{{$trans.translation.wait_transaction}}</span>
        <div v-show="data.trans && !data.shipped">
          <span class="yellow-box padding-5">{{$trans.translation.wait_delivery}}</span>
          <p><strong>{{$trans.translation.payment_date}}</strong>&nbsp;{{ data.date_paid }}</p>
        </div>
        <div v-show="data.shipped">
          <span class="green-box padding-5">{{$trans.translation.delivered}}</span>
          <p><strong>{{$trans.translation.track_info}}</strong>&nbsp;{{data.carrier}}</p>
          <p><strong>{{$trans.translation.track_number}}</strong>&nbsp;{{data.tracking_number}}</p>
          <p><strong>{{$trans.translation.payment_date}}</strong>&nbsp;{{ data.date_paid }}</p>
        </div>
      </div>
      <div class="col-2-flex-res order-product" v-for="item in data.body">
        <div class="text-row">{{item.name}}&nbsp;{{item.options.choice ? item.options.choice :  '---'}}</div>
        <div class="text-row">{{$trans.translation.price}}&nbsp;{{ $number.currency(item.price) }}&nbsp;{{$trans.translation.amount}}&nbsp;:&nbsp;{{item.qty}}</div>
      </div>
      <div>
        <table class="c-table">
          <tr v-for="item in data.shipping">
            <td colspan="4">
              {{$trans.translation.shipping_fee}}&nbsp;:&nbsp;{{ item.free ? 'free' : item.fee + '฿' }}&nbsp;({{ item.method + ' ' + item.time + ' ' + $trans.translation.days}})
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <h4 class="no-margin">{{$trans.translation.total_price}}&nbsp;:&nbsp;<span class="font-red">{{data.total}}</span>&nbsp;฿</h4></td>
          </tr>
          <tr>
            <td colspan="4">
              <label class="input-label">{{$trans.translation.address}}</label>
              <p>{{ data.address }}</p>
            </td>
          </tr>
          <tr v-show="data.shipped && !data.feedback">
            <td colspan="4">
              <feedback v-on:submit="data.feedback = true" :shop-id="data.reciever" :order-id="data.id"></feedback>
            </td>
          </tr>
          <tr v-show="!data.trans && !data.shipped">
            <td colspan="4">
              <button class="delete-btn normal-sq red-box" @click.prevent="deny(data.uid, index)">{{$trans.translation.cancle_order}}</button>
            </td>
          </tr>
          <tr v-show="!data.trans && !bankAccount.length">
            <td colspan="4">
              <button class="normal-sq help-btn" @click.prevent="getBankAccount(data.reciever)">{{$trans.translation.transaction_confirm}}</button>
            </td>
          </tr>
        </table>
        <div id="full-line" class="col-3-flex-res padding-10" v-for="account in bankAccount" v-show="!data.trans && bankAccount.length">
          <div class="text-row">
            <strong>{{ account.provider_name }}</strong>&nbsp;{{ account.name }}
          </div>
          <div class="text-row font-green">{{ account.number }}</div>
        </div>
      </div>
    </div>

    <!-- Transaction Confirm Form -->
    <form slot="footer" v-on:submit.prevent="confirm(data.uid, index)" method="post" v-if="!data.trans && bankAccount.length">
      <div class="padding-15-horizontal padding-15-bottom">
        <table class="shipping-table">
          <tr>
            <td><h4 class="no-margin font-grey">{{$trans.translation.payment_date}}</h4></td>
            <td><h4 class="no-margin font-grey">{{$trans.translation.account_provider}}</h4></td>
          </tr>
          <tr>
            <td>
              <input required pattern=".{10}" @keyup="cleave" class="form-input date width-120" id="date" type="text" v-model="date" :placeholder="$trans.translation.date_placeholder">
              <input required @keyup="cleave" class="form-input width-120" id="time" type="text" v-model="time" placeholder="00 : 00 : 00">
            </td>
            <td>
              <select required class="select-input" v-model="provider">
                <option v-for="account in bankAccount" :value="account.provider_name">{{account.provider_name}}</option>
              </select>
            </td>
          </tr>
        </table>
      </div>
      <div class="msg-btn">
        <button :disabled="$root.loading" class="msg-btn-half" type="submit">{{$trans.translation.confirm}}</button>
        <button class="msg-btn-half" @click.prevent="hide()">{{$trans.translation.close}}</button>
      </div>
    </form>
    <!-- Transaction waiting & Delivered -->
    <div slot="footer" class="msg-btn" v-else>
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>

  </modal>

</div>
</template>

<script>
import Cleave from 'cleave.js'
import feedback from './Feedback.vue'

export default {
  data() {
    return {
      orders: [],
      data: [],
      date: null,
      time: null,
      provider: null,
      name: this.userName,
      address: this.userAddress,
      phone: this.userPhone,
      index: null,
      bankAccount: [],
      loaded: false,
      tab: null,
    }
  },
  components: {
    feedback
  },
  props: {
    userName: null,
    userAddress: null,
    userPhone: null,
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
      this.$Progress.start()
      this.$http.get(this.$root.url + '/profile/order/buying/get').then(response => {
        this.orders = response.body.data;
        this.$Progress.finish()
        this.loaded = true
      });
    },
    toggleTab(id) {
      if (this.tab === id) {
        this.tab = null;
        return;
      }
      this.tab = id;
    },
    open(order, index) {
      this.$root.showModal = true
      this.data = order
      this.index = index
    },
    hide() {
      this.$root.showModal = false
      this.data = []
      this.index = null
      this.date = null;
      this.time = null;
      this.address = null;
      this.name = null;
      this.phone = null;
      this.provider = null;
      this.bankAccount = [];
    },
    confirm(uid, index) {
      this.$Progress.start();
      this.$root.loading = true
      this.$http.put(this.$root.url + '/profile/order/' + uid + '/transaction', {
        date: this.date,
        time: this.time,
        address: this.address,
        name: this.name,
        phone: this.phone,
        phone: this.phone,
        provider: this.provider,
      }).then(response => {
        this.date = null;
        this.time = null;
        this.address = null;
        this.name = null;
        this.phone = null;
        this.provider = null;
        this.$set(this.orders[index], 'trans', true);
        this.$set(this.orders[index], 'date_paid', response.body.date_paid);
        toastr.success(this.$trans.translation.success);
        this.$Progress.finish();
        this.$root.loading = false
      }, response => {
        this.$Progress.fail();
        this.$root.loading = false
        toastr.error(this.$trans.translation.error);
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
    deny(uid) {
      if (!confirm(this.$trans.translation.deny + '?')) {
        return
      } else {
        this.$http.put(this.$root.url + '/order/' + uid + '/deny', {
          type: 2
        }).then(response => {
          this.$delete(this.orders, this.index);
          toastr.success(this.$trans.translation.success);
          this.$Progress.finish();
          this.hide()
        });
      }
    },
    getBankAccount(id) {
      this.$Progress.start();
      this.$root.loading = true
      this.$http.get(this.$root.url + '/api/getter/shop_account/' + id).then((response) => {
        this.bankAccount = response.body
        this.$Progress.finish();
        this.$root.loading = false
      });
    }
  },
  created() {
    this.getMessages();
  },
}
</script>
