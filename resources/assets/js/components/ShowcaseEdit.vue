<template>

<div>
  <div style="padding: 0 15px 10px 15px;">
    <div class="add-col-panel">
		<form>
        <div class="input-group">
				<input class="input-addon-field" type="text" v-model="name" name="name">
        <button class="input-addon" @click.prevent="edit" style="border: none;"><span class="icon-checkmark"></span></button>
        </div>
		</form>
		</div>
    <div class="panel-body"><h4 class="no-margin">{{$trans.translation.showcase_products}}</h4></div>
    <div v-if="products.length" class="panel-body thumbnail-grid">
        <img v-for="product in products" :src="product.thumbnail" v-show="product.added" class="products-img-thumb">
    </div>
    <div v-else class="panel-body"><h4>{{$trans.translation.showcase_empty}}</h4></div>

    <div style="padding:15px;">
      <h4>{{$trans.translation.shop_products}}</h4>
      <table class="c-table">
        <tr>
          <th>{{$trans.translation.product_name}}</th>
          <th>{{$trans.translation.showcase_add}}</th>
        </tr>
        <tr v-for="(product, index) in products">
          <td class="m-cell">{{product.name}}</td>
          <td class="s-cell">
            <button @click.prevent="add(product.id, index)" class="round-btn" v-bind:class="{ 'red-bg': product.added === true, 'green-bg': product.added === false}">
              <small v-bind:class="{ 'icon-cross': product.added === true, 'icon-checkmark': product.added === false}"></small>
            </button>
          </td>
        </tr>
      </table>
    </div>

  </div>
</div>

</template>

<script>
	export default{
		data() {
			return {
        name: this.showcaseName,
        products: [],
        url: window.Closet.url,
        user_id: window.Closet.user.user,
				trans: this.$trans,
			}
		},

		props: {
      showcaseName: null,
      showcaseId: null,
      shopSlug: null,
		},
		methods: {
      getProduct() {
          this.$http.get(this.url + '/showcase_ajax/myproducts/' + this.showcaseId).then((response)=> { this.products = response.body.data });
      },

      edit(){
				this.$http.put(this.url + '/showcase_ajax/update/' + this.showcaseId ,{
					name: this.name
				}).then((response)=> {
  					toastr.success(this.$trans.translation.success)
				}, (response) => {
            toastr.error(this.$trans.translation.error)
        });
			},

      add(productId, index){
        this.$http.post(this.url + '/showcase_ajax/products/' + productId + '/showcase/' + this.showcaseId).then((response)=> {
            if (this.products[index].added) {
              this.$set(this.products[index], 'added', false)
            } else {
              this.$set(this.products[index], 'added', true)
            }
        }, (response) => {
            toastr.error(this.$trans.translation.error)
        });
      },

    },

    created() {
      this.getProduct();
      this.getCurrentProduct();
  	}

	}
</script>
