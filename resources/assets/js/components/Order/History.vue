<template>
<div v-show="orders.length">
  <vue-progress-bar></vue-progress-bar>
  <pagination v-on:switched="meta[0].current_page = $event" :meta="meta"></pagination>
  <table class="c-table">
    <tr v-for="(item, index) in orders">
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
            {{$trans.translation.shipping_fee}}&nbsp;:&nbsp;{{ item.free ? 'free' : item.fee + '&#3647;' }}&nbsp;({{ item.method + ' ' + item.time + ' ' + $trans.translation.days}})
          </td>
        </tr>
        <tr>
          <td colspan="4"><h4 class="no-margin">{{$trans.translation.total_price}}&nbsp;:&nbsp;<span class="font-red">{{data.total}}</span>&nbsp;&#3647;</h4></td>
        </tr>
        <tr>
          <td colspan="4">
            <label class="input-label">{{$trans.translation.address}}</label>
            <p>{{ data.address }}</p>
          </td>
        </tr>
        <tr v-show="data.trans && !data.shipped">
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.completed_transaction}}</h4>
            <h4>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</h4>
          </td>
        </tr>
        <tr>
          <td colspan="4">
            <h4 class="no-margin font-green">{{$trans.translation.delivered}}</h4>
            <p>{{$trans.translation.payment_date}}&nbsp;{{ data.date_paid }}</p>
            <p>{{$trans.translation.track_info}}&nbsp;{{data.carrier}}</p>
            <p>{{$trans.translation.track_number}}&nbsp;{{data.tracking_number}}</p>
          </td>
        </tr>
      </table>
    </div>

    <div class="msg-btn" v-show="!data.trans || data.shipped">
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>

  </modal>
  <pagination v-on:switched="meta[0].current_page = $event" :meta="meta"></pagination>
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
  methods: {
    get() {
        this.$http.get(this.$root.url + '/profile/order/'+ this.type +'/history/get').then((response)=> {
           this.orders = response.body.data;
           this.meta.push({total_pages: response.body.last_page, current_page: response.body.current_page})
         })
    },
    switched(){
      this.$Progress.start()
      this.$http.get(this.$root.url + '/profile/order/'+ this.type +'/history/get?page=' + this.$route.query.page ).then((response) => {
        this.orders = [];
        this.orders = response.body.data
        this.$Progress.finish()
      })
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
    },
  },

  created() {
    this.get();
  }
}
</script>
