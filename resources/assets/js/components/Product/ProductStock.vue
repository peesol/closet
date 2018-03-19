<template>
<div>
  <div class="panel-heading">
    <label class="full-label heading">{{$trans.translation.stock_edit}}</label>
  </div>
  <div v-if="products.length">

    <div class="row-list flex flex-start-res" v-for="(product, index) in products">
      <div class="text-wrap padding-15-right">
        <label class="input-label">{{product.name}}</label>
      </div>
      <div class="flex">
        <div class="input-group padding-15-right width-120">
          <input class="form-input-alt no-margin" min="0" type="number" v-model="product.amount">
          <button class="form-input-btn icon-checkmark" type="submit" @click.prevent="setAmount(product.uid, product.amount, index)"></button>
        </div>
        <span class="padding-15-horizontal" :class="{ 'green-box' : product.amount >= 1, 'red-box' : product.amount == 0 }">{{product.amount >= 1 ? $trans.translation.instock : $trans.translation.outstock}}</span>
      </div>
    </div>
  </div>

  <div v-else class="panel-body">
    <label class="input-label full-label">{{$trans.translation.product_none}}</label>
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
