<template>
<div class="relative">
  <load-overlay bg="white-bg" :show="!loaded" padding="50px 0"></load-overlay>
    <div id="full-line" class="half-width-res panel-body">
		<form>
      <label class="heading full-label">{{$trans.translation.name}}</label>
        <div class="input-group half-width-res">
				   <input class="input-addon-field left" type="text" v-model="name" name="name">
          <button :disabled="$root.loading" class="checkmark-btn input-addon right" @click.prevent="edit"><i class="icon-checkmark"></i></button>
        </div>
		</form>
		</div>
    <div class="panel-heading">
      <label class="full-label heading">{{$trans.translation.showcase_products}}&nbsp;<span class="number" :class="{'not-empty' : added > 0}">{{ added }}</span></label>
    </div>
    <div v-show="added > 0" class="panel-body thumbnail-grid" id="full-line">
        <img v-for="product in products" v-show="product.added" :src="product.thumbnail" class="products-img-thumb">
    </div>
    <div class="panel-heading">
      <label class="full-label heading">{{$trans.translation.shop_products}}&nbsp;<span class="number" :class="{'not-empty' : products.length}">{{ products.length }}</span></label>
    </div>
    <div class="panel-body">
      <table v-show="products.length" class="c-table">
        <tr>
          <th class="center">{{$trans.translation.showcase_add}}</th>
          <th class="center">{{$trans.translation.product_name}}</th>
        </tr>
        <tr v-for="(product, index) in products">
          <td class="center">
            <a @click.prevent="add(product.id, index)"><i v-bind:class="{ 'icon-checked font-green': product.added === true, 'icon-unchecked': product.added === false}"></i></a>
          </td>
          <td class="break-word">
            {{product.name}}
          </td>
        </tr>
      </table>
    </div>
    <div v-show="!products.length" class="padding-15-vertical align-center">
      <h2 class="font-grey">{{$trans.translation.product_none}}</h2>
    </div>
</div>

</template>

<script>
	export default{
		data() {
			return {
        name: this.showcaseName,
        products: [],
        loaded: false
			}
		},

		props: {
      showcaseName: null,
      showcaseId: null,
      shopSlug: null,
		},
    computed: {
      added: function () {
        var total = 0;
        this.products.forEach(function (item) {
          if(item.added === true) {
            total++;
          }
        });
        return total;
      }
    },
		methods: {
      getProduct() {
          this.$http.get(this.$root.url + '/' + this.shopSlug + '/edit/showcase/' + this.showcaseId + '/get_product').then(response => {
            this.products = response.body.data
            this.loaded = true
          });
      },

      edit(){
        this.$root.loading = true
				this.$http.put(this.$root.url + '/' + this.shopSlug + '/edit/showcase/' + this.showcaseId + '/update',{
					name: this.name
				}).then(response => {
          this.$requestTimer(2000)
			    toastr.success(this.$trans.translation.success)
				}, response => {
          this.$requestTimer(2000)
          toastr.error(this.$trans.translation.error)
        });
			},

      add(productId, index){
        this.$http.post(this.$root.url + '/' + this.shopSlug + '/edit/showcase/' + this.showcaseId + '/add_product/' + productId).then(response => {
            if (this.products[index].added) {
              this.$set(this.products[index], 'added', false)
            } else {
              this.$set(this.products[index], 'added', true)
            }
        }, response => {
            toastr.error(this.$trans.translation.error)
        });
      },

    },

    created() {
      this.getProduct()
  	}

	}
</script>
