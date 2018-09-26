<template>
<div v-show="orders.length">
  <vue-progress-bar></vue-progress-bar>
  <pagination v-show="orders.length > 40" v-on:switched="meta[0].current_page = $event" :meta="meta"></pagination>
  <table class="c-table">
    <tr v-for="(item, index) in orders">
      <td><a class="link-text"  @click.prevent="open(item, index)">{{item.title}}</a></td>
      <td><span class="float-right">{{item.created_at}}</span></td>
    </tr>
  </table>

  <modal>
    <div slot="body">
        <div class="panel-heading">
          <h4 class="no-margin">{{ data.title }}<span v-show="data.cancled" class="font-red">{{ status}}</span></h4>
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
        <table class="c-table">
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
        </table>
    </div>

    <div slot="footer" class="msg-btn">
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>
  </modal>
  <pagination v-show="orders.length > 40" v-on:switched="meta[0].current_page = $event" :meta="meta"></pagination>
</div>
</template>

<script>
import Pagination from './partials/Pagination'

export default {
  data() {
    return {
      orders: [],
      data: [],
      tracking_number: null,
      track_info: null,
      index: null,
      translate: this.$trans,
      meta: []
    }
  },
  components: {
    Pagination
  },
  props: [
    'type'
  ],
  watch: {
    '$route.query': {
      handler() {
        this.switched()
      },
      deep: true
    }
  },
  computed: {
    status: function() {
      if (this.type == 'buying') {
        return this.$trans.translation.notification_title.order_denied
      } else {
        return this.$trans.translation.notification_title.order_cancled
      }
    }
  },
  methods: {
    get() {
      this.$root.loading = true
        this.$http.get(this.$root.url + '/profile/order/'+ this.type +'/history/get').then((response)=> {
           this.orders = response.body.data;
           this.meta.push({total_pages: response.body.last_page, current_page: response.body.current_page})
           this.$root.loading = false
         })
    },
    switched(){
      this.$Progress.start()
      this.$root.loading = true
      this.$http.get(this.$root.url + '/profile/order/'+ this.type +'/history/get?page=' + this.$route.query.page ).then((response) => {
        this.orders = [];
        this.orders = response.body.data
        this.$Progress.finish()
        this.$root.loading = false
      })
    },
    open(order, index) {
      this.$root.showModal = true
      this.data = order
      this.index = index
    },
    hide() {
      this.$root.showModal = false
      this.track_info = null;
      this.track_number = null;
    },
  },

  created() {
    this.get();
  }
}
</script>
