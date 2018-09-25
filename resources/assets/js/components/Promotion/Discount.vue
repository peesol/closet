<template>
<div class="padding-15-horizontal overflow-x-auto">
  <h2 v-bind:class="{ 'font-red' : points === 0 ,'font-green' : points > 0}">{{$trans.translation.points}}&nbsp;:&nbsp;{{remaining_points}}</h2>
  <div class="padding-30-bottom" v-show="discount_products.length">
    <label class="full-label grey-bg heading padding-10">{{$trans.translation.discount}}</label>
    <div class="col-4-flex-res full-width panel-heading" v-for="(item, index) in discount_products">
      <div class="text-nowrap text-row">{{item.name}}</div>
      <div class="text-row">
        <s>{{$number.currency(item.price)}}&nbsp;฿</s>&nbsp;
        <font class="font-green">{{$number.currency(item.discount_price)}}&nbsp;฿</font>
      </div>
      <div class="text-row">
        <font class="font-red">{{$trans.translation.expired}}&nbsp;{{item.discount_date}}</font>
      </div>
      <div class="align-right">
        <button @click.prevent="remove(item.uid, index)" class="flat-btn"><i class="fas fa-trash-alt"></i></button>
      </div>
    </div>
  </div>
  <label class="full-label heading padding-10 grey-bg">{{$trans.translation.shop_products}}</label>
  <div class="col-3-flex-res full-width panel-heading" v-for="(item, index) in products">
    <div class="text-nowrap text-row">{{item.name}}</div>
    <div class="text-row">
      {{$number.currency(item.price)}}&nbsp;฿
    </div>
    <div class="align-right">
      <button @click.prevent="open(item, index)" class="flat-btn"><i class="fas fa-plus"></i></button>
    </div>
  </div>

  <modal name="open-msg" @before-open="beforeOpen" :clickToClose="false" :scrollable="true" :height="'auto'" :adaptive="true">
    <form @submit.prevent="apply(data.uid, index)">
      <p class="break-word padding-15-horizontal">{{$trans.translation.product}}&nbsp;:&nbsp;{{ data.name }}</p>
      <div class="padding-15-horizontal padding-15-bottom align-center">
        <p>{{$trans.translation.price}}&nbsp;:{{ $number.currency(data.price) }}&nbsp;฿
          <font class="font-green" v-show="discount">&nbsp;<i class="fas fa-caret-right"></i>&nbsp;{{ discounted(data.price) }}</font>
        </p>
        <input required class="form-input width-120" type="number" v-model="discount" :placeholder="$trans.translation.discount" min="1" :max="data.price - 1">
        <span>{{$trans.translation.baht}}</span>
      </div>
      <div class="msg-btn">
        <button :disabled="$root.loading" class="msg-btn-half" :class="{'green' : discount}" type="submit">{{$trans.translation.confirm}}</button>
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
      discount_products: [],
      products: [],
      discount: null,
      formVisible: null,
      remaining_points: this.points,
      data: [],
      index: null
    }
  },
  props: {
    points: null,
  },
  methods: {
    discounted(price) {
      return this.$number.currency(price - this.discount);
    },
    beforeOpen(event) {
      this.data = event.params.data
      this.index = event.params.index
    },
    open(product, index) {
      this.$modal.show('open-msg', {
        data: product,
        index: index
      });
    },
    hide() {
      this.$modal.hide('open-msg');
      this.data = []
      this.index = null
    },
    toggleForm(id) {
      if (this.formVisible === id){
        this.formVisible = null;
        return;
      }
      this.formVisible = id;
    },
    getProduct() {
      this.$root.loading = true
      this.$http.get(this.$root.url + '/profile/promotions/manage/discount/product').then(response => {
        this.products = response.body.products;
        this.discount_products = response.body.discount_products.data;
        this.$root.loading = false
      });
    },
    apply(uid, index) {
      if (!confirm(this.$trans.translation.confirm + '?')) {
        return
      } else {
        if (this.remaining_points < 1) {
          alert(this.$trans.translation.not_enough_points)
        } else {
          this.$root.loading = true
          this.$http.put(this.$root.url + '/profile/promotions/manage/discount/' + uid + '/add', {discount:this.discount}).then(response => {
            this.hide()
            this.$root.loading = false
            toastr.success(this.$trans.translation.success);
            this.$delete(this.products, index);
            this.remaining_points--
            this.discount_products.push(response.body);
            this.discount = null;
            this.formVisible = null;
          }, response => {
            this.$root.loading = false
            this.formVisible = null;
            toastr.error(this.$trans.translation.error);
          });
        }
      }
    },
    remove(uid, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return
      } else {
        this.$http.put(this.$root.url + '/profile/promotions/manage/discount/' + uid + '/delete').then(response => {
            this.products.push(this.discount_products[index]);
            this.discount_products.splice(index, 1);
        });
      }
    }
  },
  created() {
    this.getProduct()
  }
}
</script>
