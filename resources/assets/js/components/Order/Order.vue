<template>
<div>
  <div class="padding-15-top padding-15-horizontal">
      <div v-show="!order.status.trans">
        <span class="red-box padding-5">{{ $trans.translation.wait_transaction }}</span>
        <button class="help-btn no-shadow padding-5" @click="open()">{{ $trans.translation.transaction_confirm }}</button>
      </div>
      <div v-show="order.status.trans && !order.status.shipped">
        <span class="yellow-box padding-5">{{ $trans.translation.wait_delivery }}</span>
      </div>
      <div v-show="order.status.shipped">
        <span class="green-box padding-5">{{ $trans.translation.shipped }}</span>
        <button v-show="!order.status.feedback" class="help-btn no-shadow padding-5" @click="open()">{{ $trans.translation.write_review }}</button>
      </div>
  </div>

  <div class="padding-15-horizontal" id="full-line">
    <p>
      {{ order.title }}<br>
      {{ $trans.translation.seller }}&nbsp;{{ order.reciever }}
    </p>
    <button class="delete-btn margin-10-bottom normal-sq red-box" @click.prevent="deny(order.uid)">{{$trans.translation.cancle_order}}</button>
    <table class="c-table">
      <tr>
        <th>{{ $trans.translation.products }}</th>
      </tr>
      <tr v-for="item in order.body">
        <td>
          {{ item.name }}&nbsp;{{ item.options.choice }}&nbsp;{{ $trans.translation.price }}&nbsp;{{ $number.currency(item.price) }}&nbsp;&times;&nbsp;{{ item.qty }}
        </td>
      </tr>
      <tr>
        <td>
          {{ $trans.translation.total_products }}&nbsp;{{ order.subtotal }}&nbsp;฿<br>
          {{$trans.translation.shipping_fee}}&nbsp;{{ order.shipping.free ? 'free' : order.fee + ' ฿' }}&nbsp;({{ order.shipping.method + ' ' + order.shipping.time + ' ' + $trans.translation.days}}
          &nbsp;<small>{{ order.shipping.multiply ? '+' + order.shipping.multiply_by + ' ฿ ' + $trans.translation.multiply_by : ''}}</small>)<br>
          <strong class="font-green">&nbsp;{{ $trans.translation.total_shipping }}&nbsp;{{ order.total }}&nbsp;฿</strong>
        </td>
      </tr>
    </table>
    <p>
      {{ $trans.translation.address }}<br>
      {{ order.address }}
    </p>
  </div>
  <div v-show="!order.trans && bankAccounts.length" class="panel-heading">
    <h2 class="font-grey no-margin">{{$trans.translation.payment_method}}</h2>
  </div>
  <div id="full-line" class="col-3-flex-res padding-10" v-for="account in bankAccounts" v-show="!order.trans && bankAccounts.length">
    <div class="text-row">
      <strong>{{ account.provider_name }}</strong>&nbsp;<i v-show="account.type == 'PromptPay'" class="font blue-bg">{{ $trans.translation.promptpay }}</i>&nbsp;{{ account.name }}
    </div>
    <div class="text-row font-green">{{ account.number }}</div>
  </div>

  <modal>
    <!-- Transaction Confirm Form -->
    <form slot="body" class="relative" v-on:submit.prevent="confirm(order.uid)" v-show="!order.status.trans">
      <div class="padding-30 col-2-flex-res">
        <div class="text-row form-group">
          <label class="full-label input-label">{{$trans.translation.payment_date}}</label>
          <input required pattern=".{10}" @keyup="cleave" class="form-input date width-120" id="date" type="text" v-model="date" :placeholder="$trans.translation.date_placeholder">
          <input required @keyup="cleave" class="form-input width-120" id="time" type="text" v-model="time" placeholder="00 : 00 : 00">
        </div>
        <div class="text-row form-group">
          <label class="full-label input-label">{{$trans.translation.account_provider}}</label>
          <select required class="select-input" v-model="provider">
            <option v-for="account in bankAccounts" :value="account.provider_name + ' ' + account.type">{{account.provider_name }}&nbsp;{{account.type == 'PromptPay' ? 'PromptPay' : null}}</option>
          </select>
        </div>
      </div>
      <div class="msg-btn">
        <button :disabled="$root.loading" class="msg-btn-half" :class="{'green' : date && time && provider}" type="submit">{{$trans.translation.confirm}}</button>
        <button class="msg-btn-half" @click.prevent="hide()">{{$trans.translation.close}}</button>
      </div>
    </form>
    <div slot="body" v-show="order.status.shipped">
      <feedback ref="feedback" v-on:disable="btnDisabled = $event" v-on:success="order.status.feedback = true, hide()" :status="order.status.feedback" :shop-id="order.reciever_id" :order="order.uid"></feedback>
      <div class="msg-btn">
        <button :disabled="btnDisabled" class="msg-btn-half" :class="{'green' : !btnDisabled}" @click.prevent="$refs.feedback.submit()">{{$trans.translation.confirm}}</button>
        <button class="msg-btn-half" @click.prevent="hide()">{{$trans.translation.close}}</button>
      </div>
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
      order: this.data,
      date: null,
      time: null,
      provider: null,
      bankAccounts: this.accounts,
      btnDisabled: true
    }
  },
  components: {
    feedback
  },
  props: ['data', 'accounts'],
  methods: {
    open() {
      this.$root.showModal = true
    },
    hide() {
      this.date = null
      this.time = null
      this.$root.showModal = false
    },
    confirm(uid) {
      this.$Progress.start();
      this.$root.loading = true
      this.$http.put(this.$root.url + '/order/' + uid + '/transaction', {
        date: this.date,
        time: this.time,
        provider: this.provider,
      }).then(response => {
        this.date = null
        this.time = null
        this.$set(this.order.status, 'trans', true)
        this.$set(this.order.status, 'date_paid', response.body.date_paid)
        this.hide();
        toastr.success(this.$trans.translation.success)
        this.$Progress.finish()
        this.$root.loading = false
      }, response => {
        this.$Progress.fail()
        this.$root.loading = false
        toastr.error(this.$trans.translation.error)
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
      this.$root.loading = true
      if (!confirm(this.$trans.translation.deny + '?')) {
        return
      } else {
        this.$http.put(this.$root.url + '/order/' + uid + '/deny', {
          type: 2
        }).then(response => {
          window.location.href = this.$root.url + '/order/buying'
        }, response => {
          this.$root.loading = false
          toastr.error(this.$trans.translation.error)
        });
      }
    },
  }
}
</script>
