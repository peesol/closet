<template>
<div>
	<div class="panel-heading"><h3 class="no-margin">{{$trans.translation.products}}</h3></div>
		<div v-if="products.length" class="panel-body">
			<div v-for="(product, index) in products" class="col-product-edit">
				<img class="col-product-img" :src="product.thumbnail">
				<div>
				<h4 class="no-margin"><a class="link-text" :href="url + '/product/'+ product.uid" style="font-size:1.2em;">{{product.name}}</a></h4>
				<p class="no-margin">{{$trans.translation.price}}&nbsp:&nbsp{{product.price}}</p>
				<p class="no-margin">{{$trans.translation.category}}&nbsp:&nbsp{{product.category}}</p>
				<p class="no-margin">{{$trans.translation.by}}&nbsp<a class="link-text" :href="url + '/'+ product.slug">{{product.shop}}</a></p>
				<button @click.prevent="removeProduct(product.id)" class="delete-btn absolute" style="bottom:0;"><span class="icon-bin"></span></button>
				</div>
			</div>
		</div>
		<div v-else class="panel-body">
			<p class="no-margin">{{$trans.translation.col_product_none}}</p>
		</div>
</div>
</template>

<script>

export default {
	data() {
		return {
			products: [],
			url: window.Closet.url,
		}
	},
    methods: {
			getProduct() {
  					this.$http.get(this.url + '/collection_ajax/products/' + this.$root.colId).then((response) => { this.products = response.body.data; });
  				},
 			removeProduct(productId, index) {
 					if(!confirm(this.$trans.translation.delete_confirm)){
						return;
					}

  					this.$http.delete(this.url + '/collection/' + this.$root.colId + '/delete/' + productId)
  					.then((response) => {
  						toastr.success(this.$trans.translation.success);
  						this.products.splice(index, 1);
					});
  				},
    },

    created() {
    	this.getProduct();
    },
}
</script>
