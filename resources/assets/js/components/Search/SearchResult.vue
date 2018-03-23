<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <search-filter></search-filter>
  <div v-if="products.length">
    <div class="panel-body thumbnail-grid">
      <div class="products-wrap" v-for="product in products[0]">
        <div class="products-img">
          <a :href="$root.url + '/product/' + product.uid">
        <img class="products-img-thumb" :src="src + product.thumbnail"alt="image">
      </a>
          <div v-if="!product.discount_price">
            <span class="price bottom-left">{{ $number.currency(product.price) }}&nbsp;&#3647;</span>
          </div>

          <div v-else>
            <span class="discount top-right">Sale</span>
            <span class="price bottom-left">
          <strike>{{ product.price }}&#3647;</strike>
          <small class="icon-next-arrow"></small>
          <font>{{ $number.currency(product.discount_price) }}&nbsp;&#3647;</font>
        </span>
          </div>

        </div>
        <div class="details">
          <a class="product-name" :href="$root.url + '/product/' + product.uid">{{product.name}}</a>
          <p class="product-p">
            {{ $trans.translation.price }}&nbsp;<span>{{ $number.currency(product.price) }}&nbsp;&#3647;</span>
          </p>
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
import algolia from 'algoliasearch'
import algoliaHelper from 'algoliasearch-helper'
export default {
  components: {
    Pagination,
    SearchFilter
  },
  data() {
    return {
      src: 'https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/thumbnail/',
      products: {},
      meta: {},
    }
  },
  watch: {
    '$route.query': {
      handler() {
        this.search()
      },
      deep: true
    }
  },
  methods: {
    search() {
      const client = algolia('40LVMO82Y8', 'b1bd2a6d3bfdb0f70c02b69e9eb00472')
      const helper = algoliaHelper(client, 'products', {
        hitsPerPage: 20,
      });
      const products = []
      const meta = []
      helper.on('result', function(data) {
        products.push(data.hits)
        meta.push({
          total_pages: data.nbPages,
          current_page: data.page
        })
      });
      if (this.$route.query.c) {
        helper.addNumericRefinement('category_id', '=', this.$route.query.c)
      }
      if (this.$route.query.sub) {
        helper.addNumericRefinement('subcategory_id', '=', this.$route.query.sub)
      }
      if (this.$route.query.type) {
        helper.addNumericRefinement('type_id', '=', this.$route.query.type)
      }
      if (this.$route.query.min) {
        helper.addNumericRefinement('price', '>=', this.$route.query.min)
      }
      if (this.$route.query.max) {
        helper.addNumericRefinement('price', '<=', this.$route.query.max)
      }
      if (this.$route.query.max && this.$route.query.min) {
        helper.addNumericRefinement('price', '>=', this.$route.query.min)
        helper.addNumericRefinement('price', '<=', this.$route.query.max)
      }
      this.$Progress.start()
      helper.setQuery(this.$route.query.p).setPage(this.$route.query.page).search()
      this.products = products
      this.meta = meta
      this.$Progress.finish()
    }
  },
  mounted() {
    this.search()
  }
}
</script>
