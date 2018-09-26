<template>
<div class="relative">
  <vue-progress-bar></vue-progress-bar>
  <load-overlay bg="white-bg" :show="!this.loaded"></load-overlay>

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

  <modal name="open-msg" @before-open="beforeOpen" :clickToClose="false" :scrollable="true" :height="'auto'" :adaptive="true">
    <div class="panel-heading">
      <h4 class="no-margin">{{ data.title }}</h4>
    </div>
    <div class="panel-body relative scrollable">
      <load-overlay bg="white-bg" :show="$root.loading" padding="70px 0"></load-overlay>
      <table class="c-table">
        <tr>
          <th class="overflow-hidden">{{$trans.translation.product_name}}</th>
          <th class="center">{{$trans.translation.choice}}</th>
          <th class="center">{{$trans.translation.price}}</th>
          <th class="center">{{$trans.translation.amount}}</th>
        </tr>
        <tr v-for="item in data.body">
          <td class="overflow-hidden">{{item.name}}</td>
          <td class="m-cell center">{{item.options.choice ? item.options.choice : '---'}}</td>
          <td class="s-cell center">{{item.price}}</td>
          <td class="s-cell center">{{item.qty}}</td>
        </tr>
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
        <tr v-show="!data.trans">
          <td colspan="4">
            <h3 class="no-margin font-red">{{$trans.translation.wait_transaction}}</h3>
          </td>
        </tr>
        <tr v-show="data.trans && !data.shipped">
          <td colspan="4">
            <h3 class="no-margin font-green">{{$trans.translation.wait_delivery}}</h3>
            <p>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</p>
          </td>
        </tr>
        <tr v-show="data.shipped">
          <td colspan="4">
            <h3 class="no-margin font-green">{{$trans.translation.delivered}}</h3>
            <p>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</p>
            <p>{{$trans.translation.track_info}}&nbsp;{{data.carrier}}</p>
            <p>{{$trans.translation.track_number}}&nbsp;{{data.tracking_number}}</p>
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
        <tr v-show="!data.trans && bankAccount.length" v-for="account in bankAccount">
          <td col>{{ account.provider_name }}</td>
          <td colspan="2">{{ account.number }}</td>
          <td>{{ account.name }}</td>
        </tr>
      </table>
    </div>
    <!-- Transaction Confirm Form -->
    <form v-on:submit.prevent="confirm(data.uid, index)" method="post" v-if="!data.trans && bankAccount.length">
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
    <div class="msg-btn" v-else>
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
        this.$modal.hide('open-msg');
        this.$set(this.orders[index], 'trans', true);
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
    deny(uid, index) {
      if (!confirm(this.$trans.translation.deny + '?')) {
        return
      } else {
        this.$http.put(this.$root.url + '/order/' + uid + '/deny', {
          type: 2
        }).then(response => {
          this.$modal.hide('open-msg');
          this.$delete(this.orders, index);
          toastr.success(this.$trans.translation.success);
          this.$Progress.finish();
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
