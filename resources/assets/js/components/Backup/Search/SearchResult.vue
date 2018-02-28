<template>
<div>
<vue-progress-bar></vue-progress-bar>
<search-filter></search-filter>
<div v-if="products.length">
  <div class="panel-body thumbnail-grid">
    <div v-for="product in products" class="products-wrap">
    <div class="products-img">
      <img class="products-img-thumb" :src="src + product.thumbnail"alt="image">
    </div>
      <h4 class="product-name">{{product.name}}</h4>
      <div class="product-detail-wrap">
        <p class="product-p">{{ $trans.translate.price }} : {{ $number.currency(product.price) }}</p>
        <p class="product-p">{{ $trans.translate.category }} : {{ product.category_id }}//{{ product.subcategory_id }}//{{ product.type_id }}</p>
      </div>
    </div>
  </div>
  <pagination :meta="meta"></pagination>
</div>
<div v-else>
  no results
</div>
</div>

</template>

<script>
import Pagination from './partials/Pagination'
import SearchFilter from './partials/Filter'
export default {
  components: {
    Pagination,
    SearchFilter
  },
  data() {
    return {
      src: 'https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/',
      products: [],
      meta: {},
    }
  },
  watch:{
    '$route.query': {
      handler (query = this.$route.query) {
        console.log(query);
        this.getData(this.$route.query.page, query)
      },
      deep: true
    }
  },
  methods: {
    getData(page = this.$route.query.page, query = this.$route.query) {
      this.$Progress.start()
      this.$http.get(this.$root.url + '/search/result/products', {
        params: {
          page,
          ...query
        }
      }).then((response) => {
        this.products = response.body.data;
        this.meta = response.body.meta;
        this.$Progress.finish()
      })
    }
  },
  mounted() {
    this.getData()
  }
}
</script>
