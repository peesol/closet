<template>
<div>
  <slick ref="slick" :options="slickOptions">

    <div v-for="product in products" v-show="products.length" class="carousel-thumb-wrap">
      <a :href="$root.url + '/product/' + product.uid">
          <img class="products-img-thumb" :src="'https://s3-ap-southeast-1.amazonaws.com/images.closet.com' + path + product.thumbnail" :alt="product.thumbnail">
          <div class="thumb-title">
            <a :href="$root.url + '/product/' + product.uid">{{ product.name }}</a>
    </div>

    <span v-show="product.discount_price" class="thumb-price bottom-left">
            <strike>{{ product.price }}&#3647;</strike>
            {{ product.discount_price }}&#3647;
    </span>

    <span v-show="!product.discount_price" class="thumb-price bottom-left">{{ $number.currency(product.price) }}&#3647;</span>

    </a>
</div>

<img v-show="imgs.length" v-for="img in imgs" :src="'https://s3-ap-southeast-1.amazonaws.com/images.closet.com' + path + img.filename" :alt="img.filename">
</slick>
</div>
</template>

<script>
import Slick from 'vue-slick'
import {
  options
} from '../misc/slick-options'

export default {
  components: {
    Slick
  },
  data() {
    return {
      slickOptions: options({
        view: this.slickFor
      }),
    };
  },
  props: {
    products: [],
    imgs: [],
    path: null,
    slickFor: null,
  },
}
</script>
