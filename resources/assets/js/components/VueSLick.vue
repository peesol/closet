<template>
<div>
  <slick ref="slick" :options="slickOptions">

    <div v-for="product in products" v-show="products.length" class="carousel-thumb-wrap">
      <a :href="$root.url + '/product/' + product.uid">
        <img class="products-img-thumb" :src="img_source + path + product.thumbnail" :alt="product.thumbnail">
    <span v-show="product.discount_price" class="sale top-right">Sale</span>
    <span v-if="product.discount_price" class="thumb-price-discount bottom-left">{{ $number.currency(product.discount_price) }}&#3647;</span>

    <span v-else class="thumb-price bottom-left">{{ $number.currency(product.price) }}&#3647;</span>
    </a>
    </div>

    <img v-show="imgs.length" v-for="img in imgs" :src="img_source + path + img.filename" :alt="img.filename">
    <img v-show="banners !== null" v-for="img in banners" :src="img_source + '/banner/banner' + img + '.jpg'" alt="banner">
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
    banners: null,
    path: null,
    slickFor: null,
  },
}
</script>
