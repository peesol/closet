<template>
<div style="padding:15px;">
  <h2 v-bind:class="{ 'red-font' : points === 0 ,'green-font' : points !== 0}">{{$trans.translation.points}}&nbsp;:&nbsp;{{points}}</h2>
  <table class="c-table" v-show="discount_products.length">
    <tr>
      <th colspan="5">{{$trans.translation.discount}}</th>
    </tr>
    <tr v-for="(item, index) in discount_products">
      <td class="m-cell overflow-hidden" style="width:100%;">{{item.name}}</td>
      <td class="m-cell"><strike>{{numeral(item.price)}}&nbsp;&#3647;</strike>&nbsp;<small class="icon-next-arrow"></small>
        <font class="green-font">{{numeral(item.discount_price)}}&nbsp;&#3647;</font>
      </td>
      <td class="m-cell">{{item.discount_date}}</td>
      <td class="s-cell">
        <button @click.prevent="remove(item.uid, index)" class="round-btn delete-btn">
          <small class="icon-cross"></small>
        </button>
      </td>
    </tr>
  </table>
  <table class="c-table">
    <tr>
      <th colspan="3">{{$trans.translation.shop_products}}</th>
    </tr>
  </table>
  <table class="c-table" v-for="(item, index) in products">
    <tr>
      <td class="m-cell overflow-hidden" style="width:100%;">{{item.name}}</td>
      <td class="m-cell">{{numeral(item.price)}}&nbsp;&#3647;</td>
      <td class="s-cell">
        <button @click.prevent="toggleForm(item.id)" class="round-btn">
          <small class="icon-plus grey-font"></small>
        </button>
      </td>
    </tr>
    <tr v-show="formVisible === item.id">
      <td colspan="3" style="background-color:#efefef;">
        <div class="input-group">
          <form v-on:submit.prevent="apply(item.uid, index)">
            <input style="height:40px;" type="number" v-model="discount" :placeholder="$trans.translation.discount" min="1" :max="item.price - 1">
            <span class="input-addon" style="border:none;">{{$trans.translation.baht}}</span>
            <button type="submit" class="round-btn add-btn"><small class="icon-checkmark"></small></button>
          </form>
        </div>
      </td>
    </tr>
  </table>
</div>
</template>

<script>
import numeral from 'numeral'
export default {
  data() {
    return {
      discount_products: [],
      products: [],
      discount: null,
      formVisible: null,
    }
  },
  props: {
    points: null,
  },
  methods: {
    numeral: function(price) {
      return numeral(price).format('0,0')
    },
    toggleForm(id) {
      if (this.formVisible === id){
        this.formVisible = null;
        return;
      }
      this.formVisible = id;
    },
    getProduct() {
      this.$http.get(this.$root.url + '/profile/promotions/manage/discount/product').then((response) => {
        this.products = response.data.products;
        this.discount_products = response.data.discount_products;
      });
    },
    apply(uid, index) {
      if (!confirm(this.$trans.translation.confirm + '?')) {
        return
      } else {
        this.$http.put(this.$root.url + '/profile/promotions/manage/discount/' + uid + '/add', {discount:this.discount}).then((response) => {
          if (this.promotions.discount === 0) {
            alert(this.$trans.translation.not_enough_points)
          } else {
            this.products.splice(index, 1);
            this.promotions.discount--
            this.discount_products.push(response.body);
            this.discount = null;
          }
        });
      }
    },
    remove(uid, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return
      } else {
        this.$http.put(this.$root.url + '/profile/promotions/manage/discount/' + uid + '/delete').then((response) => {
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
