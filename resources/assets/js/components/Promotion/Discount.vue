<template>
<div class="padding-15-horizontal overflow-x-auto">
  <h2 v-bind:class="{ 'font-red' : points === 0 ,'font-green' : points !== 0}">{{$trans.translation.points}}&nbsp;:&nbsp;{{remaining_points}}</h2>
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

  <label class="full-label heading padding-10">{{$trans.translation.shop_products}}</label>

  <div class="full-width" v-for="(item, index) in products">
    <table class="c-table no-margin">
      <tr>
        <th>{{$trans.translation.products}}</th>
        <th>{{$trans.translation.price}}</th>
        <th></th>
      </tr>
      <tr>
        <td>{{item.name}}</td>
        <td>{{$number.currency(item.price)}}</td>
        <td class="center">
          <button @click.prevent="toggleForm(item.id)" class="flat-btn"><i class="fas fa-plus font-15em"></i></button>
        </td>
      </tr>
    </table>
    <div class="full-width grey-bg padding-10" v-show="formVisible === item.id">
        <div class="input-group">
          <form v-on:submit.prevent="apply(item.uid, index)">
            <input required class="form-input-alt auto-width" type="number" v-model="discount" :placeholder="$trans.translation.discount" min="1" :max="item.price - 1">
            <span class="input-addon" style="border:none;">{{$trans.translation.baht}}</span>
            <button type="submit" class="normal-sq green-box">{{$trans.translation.confirm}}</button>
          </form>
        </div>
    </div>
  </div>
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
      remaining_points: this.points
    }
  },
  props: {
    points: null,
  },
  methods: {
    toggleForm(id) {
      if (this.formVisible === id){
        this.formVisible = null;
        return;
      }
      this.formVisible = id;
    },
    getProduct() {
      this.$http.get(this.$root.url + '/profile/promotions/manage/discount/product').then(response => {
        this.products = response.body.products;
        this.discount_products = response.body.discount_products.data;
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
            this.$root.loading = false
            toastr.success(this.$trans.translation.success);
            this.$delete(this.products, index);
            this.remaining_points--
            this.discount_products.push(response.body);
            this.discount = null;
          }, response => {
            this.$root.loading = false
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
