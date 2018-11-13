<template>
<div>
  <slick ref="slick" :options="slickOptions">

    <div v-for="product in products" v-show="products.length" class="carousel-thumb-wrap">
    <a :href="$root.url + '/product/' + product.uid">
      <img class="products-img-thumb" :src="img_source + path + product.thumbnail" :alt="product.thumbnail">
    </a>
    <span v-show="product.discount_price" class="sale top-right"></span>
    <i v-show="product.shop_type === 2" class="fas fa-check verified-profile top-left"></i>
    <span v-if="product.discount_price" class="thumb-price-discount bottom-left">
      <s>{{ $number.currency(product.price) }}</s><br>
      {{ $number.currency(product.discount_price) }}฿
    </span>
    <span v-else class="thumb-price bottom-left">{{ $number.currency(product.price) }}฿</span>

    </div>

    <img v-show="imgs.length" v-for="img in imgs" :src="img_source + path + img.filename" :alt="img.filename">

    <a v-for="banner in banners" :href="banner.link" v-show="banners.length">
      <img :src="img_source + '/banner/' + banner.filename" alt="banner">
    </a>

  </slick>
</div>
</template>

<script>
import Slick from 'vue-slick'
import { options } from '../misc/slick-options'

export default {
  components: {
    Slick
  },
  data() {
    return {
      img_source: 'https://s3-ap-southeast-1.amazonaws.com/images.closet.com',
      slickOptions: options({
        view: this.slickFor
      }),
    };
  },
  props: {
    products: [],
    imgs: [],
    banners: [],
    path: null,
    slickFor: null,
  }
}
</script>
