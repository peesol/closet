<template>
<div>
  <div class="panel-heading"><h3 class="no-margin">{{$trans.translation.stock_edit}}</h3></div>
  <div class="panel-body">
    <table class="c-table" v-if="products.length">
      <tr>
        <th>{{$trans.translation.product_name}}</th>
        <th>{{$trans.translation.amount}}</th>
        <th>{{$trans.translation.stock}}</th>
      </tr>
      <tr v-for="(product, index) in products">
        <td class="m-cell overflow-hidden">{{product.name}}</td>
        <td class="s-cell">
          <div class="input-group">
            <input min="0" type="number" v-model="product.amount" style="background-color:#f2f2f2;">
            <button class="checkmark-btn" type="submit" @click.prevent="setAmount(product.uid, product.amount, index)">
              <small class="icon-checkmark"></small>
            </button>
          </div>
        </td>
        <td class="s-cell"><span v-bind:class="{'icon-checkmark green-font': product.amount >= 1,'icon-cross red-font': product.amount == 0}"></span></td>
      </tr>
    </table>
    <p v-else>{{$trans.translation.product_none}}</p>
  </div>
</div>
</template>

<script>
export default {
  data() {
		return {
      products: [],
		}
	},
  methods: {
      getProduct() {
          this.$http.get(this.$root.url + '/profile/myproduct/get').then((response)=> {
            return response.json()
            .then((json) => {
              this.products = json;
            });
          });
        },

        setAmount(productSlug, productAmount, index){
          this.$http.put(this.$root.url + '/profile/myproduct/stock/set_amount/' + productSlug , {
            amount: productAmount
          }).then((response) => {
            toastr.success(this.$trans.translation.saved);
            this.$set(this.products[index], 'amount', productAmount)
          });
        },
    },

  created(){
    this.getProduct();
  }

}
</script>
