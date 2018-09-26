<template>
<div class="relative">
  <load-overlay bg="white-bg" :show="!loaded"></load-overlay>
  <div class="padding-30-bot-15">
    <button class="orange-btn normal-sq" @click.prevent="open(products)" name="button">{{$trans.translation.add_your_product}}&nbsp;+</button>
  </div>
  <modal>
    <div slot="body" class="relative" style="min-height: 120px">
      <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
      <table class="c-table no-margin">
        <tr>
          <th colspan="2" class="align-center font-large">{{$trans.translation.add_your_product}}</th>
        </tr>
        <tr v-for="(item, index) in myProducts">
          <td class="overflow-hidden">{{ item.name }}</td>
          <td class="align-center">
            <a @click.prevent="addToCollection(item.id, colId, index)" class="font-15em" :class="{'font-green fas fa-check-square' : item.added, 'fas fa-plus font-grey' : !item.added}"></a>
          </td>
        </tr>
      </table>
    </div>
    <div slot="footer" class="msg-btn">
      <button class="msg-btn-full" @click.prevent="hide()">{{$trans.translation.close}}</button>
    </div>
  </modal>
  <div v-if="products.length">

    <div v-for="(product, index) in products" class="row-list flex flex-start">
      <div class="thumbnail-wrap">
        <img :src="product.thumbnail">
      </div>

      <div class="middle-wrap padding-15-left">
        <div class="full-width text-nowrap">
					<a class="link-text" :href="$root.url + '/product/'+ product.uid" style="font-size:1.2em;">{{product.name}}</a>
        </div>
        <p class="no-margin">{{$trans.translation.price}}&nbsp;:&nbsp;{{ $number.currency(product.price) }}</p>
        <p class="no-margin">{{$trans.translation.by}}&nbsp;<a class="link-text" :href="$root.url + '/'+ product.slug">{{product.shop}}</a></p>
      </div>

      <div class="button-wrap">
        <button @click.prevent="removeProduct(product.id)" class="flat-btn delete fas fa-trash-alt font-15em"></button>
      </div>
    </div>

  </div>
  <div v-else class="panel-body">
    <label class="full-label input-label">{{$trans.translation.col_product_none}}</label>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      products: [],
      myProducts:[],
      formVisible: false,
      loaded: false
    }
  },
  props: {
    colId: null,
    colSlug: null
  },
  methods: {
    open() {
      if (!this.myProducts.length) {
        this.$Progress.start()
        this.$root.loading = true
        this.$http.get(this.$root.url + '/collection/' + this.colSlug + '/edit/get_myproducts').then((response) => {
          this.myProducts = response.body;
          this.$Progress.finish()
          this.$root.loading = false
        });
      }
      this.$root.showModal = true
    },
    hide() {
      this.$root.showModal = false
      this.products = []
      this.getProduct()
    },
    getProduct() {
      this.loaded = false
      this.$http.get(this.$root.url + '/collection_api/products/' + this.colId).then((response) => {
        this.products = response.body.data;
        this.loaded = true
      });
    },
    addToCollection(productId, collectionId, index) {
      this.$http.post(this.$root.url + '/collection/' + collectionId + '/add/' + productId).then(response => {
        if (this.myProducts[index].added) {
          this.$set(this.myProducts[index], 'added', false)
          toastr.success(this.$trans.translation.delete_from_col)
        } else {
          this.$set(this.myProducts[index], 'added', true)
          toastr.success(this.$trans.translation.added_to_col)
        }
      }, response => {
        toastr.error(this.$trans.translation.error)
      });
    },
    removeProduct(productId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url + '/collection/' + this.colId + '/delete/' + productId).then(response => {
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
