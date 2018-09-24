<template>
<div>
  <div class="panel-heading">
    <label class="full-label heading">{{$trans.translation.stock_edit}}</label>
  </div>
  <div v-if="products.length">
    <div class="padding-10 flex flex-start-res" v-for="(product, index) in products">
      <div class="padding-15-right text-nowrap half-width-res">
        <label class="input-label lh-35">{{product.name}}</label>
      </div>
      <div class="half-width-res flex">
        <div class="input-group half-width">
          <input class="form-input-alt no-margin width-120" min="0" type="number" v-model="product.amount">
          <button :disabled="$root.loading" class="checkmark-btn fas fa-check" type="submit" @click.prevent="setAmount(product.uid, product.amount, index)"></button>
        </div>
        <div class="half-width align-right">
          <span class="padding-10" :class="{ 'green-box' : product.amount >= 1, 'red-box' : product.amount == 0 }">{{product.amount >= 1 ? $trans.translation.instock : $trans.translation.outstock}}</span>
        </div>
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
          this.$http.get(this.$root.url + '/api/getter/my_products').then(response=> {
            this.products = response.body
          });
        },

        setAmount(productSlug, productAmount, index){
          this.$root.loading = true
          this.$http.put(this.$root.url + '/profile/myproduct/stock/set_amount/' + productSlug , {
            amount: productAmount
          }).then(response => {
            this.$requestTimer(2000)
            toastr.success(this.$trans.translation.saved);
            this.$set(this.products[index], 'amount', productAmount)
          }, response => {
            this.$root.loading = false
            toastr.error(this.$trans.translation.error);
          });
        },
    },

  created(){
    this.getProduct();
  }

}
</script>
