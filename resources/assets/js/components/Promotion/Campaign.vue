<template>
<div>
  <h2 class="margin-20-bottom no-margin" v-bind:class="{ 'font-red' : points === 0 ,'font-green' : points > 0}">{{$trans.translation.points}}&nbsp;:&nbsp;{{remaining_points}}</h2>
  <label class="full-label heading padding-10 grey-bg">{{$trans.translation.shop_products}}</label>
  <div class="col-3-flex-res full-width panel-heading" v-for="(product, index) in products">
    <div class="text-row text-nowrap">{{ product.name }}</div>
    <div class="text-row">{{$trans.translation.price}}&nbsp;{{ $number.currency(product.price) }}&nbsp;
      <strong class="font-green" v-show="product.discount_price"><i class="fas fa-caret-right"></i>&nbsp;{{ $number.currency(product.discount_price) }}</strong>
    </div>
    <div v-if="!product.in_campaign" class="text-row align-right">
      <button class="flat-btn" @click.prevent="open(product, index)"><i class="fas fa-plus font-15em"></i></button>
    </div>
    <div v-else class="text-row">{{$trans.translation.campaign}}&nbsp;{{ product.campaign }}&nbsp;<a class="float-right font-large flat-btn delete" @click="remove(product.uid, index)">{{$trans.translation.cancle}}</a></div>
  </div>
  <modal>
    <form class="relative" slot="body" @submit.prevent="join(data.uid, index)">
      <load-overlay bg="white-bg" :show="loading" padding="30px 0"></load-overlay>
      <p class="break-word padding-15-horizontal">{{$trans.translation.product}}&nbsp;:&nbsp;{{ data.name }}</p>
      <div class="padding-15-horizontal">
        <p>{{$trans.translation.price}}&nbsp;:{{ $number.currency(data.price) }}&nbsp;฿</p>
      </div>
      <div class="panel-body">
        <select class="select-input margin-20-bottom" v-model="selected_campaign">
          <option v-for="option in campaigns" :value="{id:option.id, name:option.campaign}">{{ option.campaign }}</option>
        </select>
      </div>
      <div class="msg-btn">
        <button :disabled="loading || !selected_campaign.id" class="msg-btn-half" :class="{'green' : selected_campaign.id}" type="submit">{{$trans.translation.confirm}}</button>
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
      products: [],
      data: [],
      index: null,
      selected_campaign: {
        id: null,
        name: null
      },
      loading: false,
      remaining_points: this.points
    };
  },
  props: ['campaigns', 'points'],
  methods: {
    get() {
      this.$root.loading = true
      this.$http.get(this.$root.url + '/profile/promotions/manage/campaign/get_product').then(response => {
        this.products = response.body.data
        this.$root.loading = false
      })
    },
    join(uid, index) {
      this.loading = true
      this.$http.post(this.$root.url + '/profile/promotions/manage/campaign/add/' + uid, {
        campaign_id: this.selected_campaign.id
      }).then(response => {
        this.$set(this.products[index], 'in_campaign', true)
        this.$set(this.products[index], 'campaign', this.selected_campaign.name)
        this.selected_campaign.id = null
        this.selected_campaign.name = null
        this.remaining_points--
        this.loading = false
        this.hide()
        toastr.success(this.$trans.translation.success)
      }, response => {
        this.loading = false
        this.hide()
        toastr.error(response.body)
      })
    },
    remove(uid, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      } else {
        if (this.remaining_points < 1) {
          alert(this.$trans.translation.not_enough_points)
        } else {
          this.$root.loading = true
          this.$http.delete(this.$root.url + '/profile/promotions/manage/campaign/remove/' + uid).then(response => {
            this.$set(this.products[index], 'in_campaign', false)
            this.$root.loading = false
            toastr.success(this.$trans.translation.success)
          }, response => {
            this.$root.loading = false
            toastr.error(this.$trans.translation.error)
          })
        }
      }
    },
    open(product, index) {
      this.$root.showModal = true
      this.data = product
      this.index = index
    },
    hide() {
      this.$root.showModal = false
      this.data = []
      this.index = null
      this.selected_campaign.id = null
      this.selected_campaign.name = null
    },
  },
  created() {
    this.get()
  }
}
</script>
