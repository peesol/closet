<template>
<div>
  <label class="heading padding-15-horizontal padding-15-top">{{$trans.translation.products}}</label>

  <div v-if="products.length">

    <div v-for="(product, index) in products" class="row-list flex flex-start">
      <div class="thumbnail-wrap">
        <img :src="product.thumbnail">
      </div>

      <div class="middle-wrap padding-15-left">
        <div class="full-width text-nowrap">
					<a class="link-text" :href="$root.url + '/product/'+ product.uid" style="font-size:1.2em;">{{product.name}}</a>
        </div>
        <p class="no-margin">{{$trans.translation.price}}&nbsp;:&nbsp;{{product.price}}</p>
        <p class="no-margin">{{$trans.translation.by}}&nbsp;<a class="link-text" :href="$root.url + '/'+ product.slug">{{product.shop}}</a></p>
      </div>

      <div class="button-wrap">
        <button @click.prevent="removeProduct(product.id)" class="delete-btn round-btn">
						<small class="icon-bin"></small>
					</button>
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
    }
  },
  props: {
    colId: null
  },
  methods: {
    getProduct() {
      this.$http.get(this.$root.url + '/collection_ajax/products/' + this.colId).then((response) => {
        this.products = response.body.data;
      });
    },
    removeProduct(productId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url + '/collection/' + this.colId + '/delete/' + productId).then((response) => {
        toastr.success(this.$trans.translation.success)
        this.products.splice(index, 1)
      });
    },
  },

  created() {
    this.getProduct()
  },
}
</script>
