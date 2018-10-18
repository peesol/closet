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
      <div class="order-product">
        {{$trans.translation.total_price}}&nbsp;:&nbsp;{{data.subtotal}}&nbsp;฿
      </div>
      <div>
        <table class="c-table">
          <tr v-for="item in data.shipping">
            <td colspan="4">
              {{$trans.translation.shipping_fee}}&nbsp;:&nbsp;{{ item.free ? 'free' : data.fee + '฿' }}&nbsp;({{ item.method + ' ' + item.time + ' ' + $trans.translation.days}}
              &nbsp;<small>{{ item.multiply ? '+' + item.multiply_by + ' ฿ ' + $trans.translation.multiply_by : ''}}</small>)
            </td>
          </tr>
          <tr>
            <h4 class="no-margin">{{$trans.translation.total_shipping}}&nbsp;:&nbsp;<span class="font-red">{{data.total}}</span>&nbsp;฿</h4>
          </tr>
          <tr>
            <td colspan="4">
              <span class="font-bold">{{$trans.translation.address}}</span>
              <p class="break-word">{{ data.address }}</p>
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
    </div>

    <!-- Transaction waiting & Delivered -->
    <div slot="footer" class="msg-btn" v-show="!data.trans || data.shipped">
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>
    <!-- Shipped form -->
      <form slot="footer" v-on:submit.prevent="confirmShipping(data.uid, index)" v-show="data.trans && !data.shipped">
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
      translate: this.$trans,
      loaded: false,
      tab: null
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
      this.$Progress.start()
      this.$http.get(this.$root.url + '/order/selling/get').then(response=> {
         this.orders = response.body.data
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
      this.track_info = null;
      this.track_number = null;
      this.deny_reason = null;
      this.deny_form = false;
    },
    confirmShipping(uid, index){
      this.$Progress.start();
      this.$root.loading = true
      this.$http.put(this.$root.url + '/order/' + uid + '/confirm_shipping', {
        carrier: this.track_info,
        tracking_number: this.tracking_number,
      }).then(response => {
        this.track_info = null;
        this.track_number = null;
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
    deny(uid) {
      if (!confirm(this.$trans.translation.deny + '?')) {
        return
      } else {
        this.$http.put(this.$root.url + '/order/' + uid + '/deny', {
          reason: this.deny_reason,
          type: 1
        }).then(response => {
          this.deny_reason = null;
          this.deny_form = false;
          this.$delete(this.orders, this.index);
          toastr.success(this.$trans.translation.success);
          this.$Progress.finish();
          this.hide()
        });
      }
    }
  },

  created() {
    this.getMessages();
  }
}
</script>
