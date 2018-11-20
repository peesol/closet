<template>
<div>
  <slick ref="slick" :options="slickOptions">
    <a class="banner" v-for="banner in banners" :href="banner.link" v-show="banners.length">
        <img class="mobile-only" :src="img_source + banner.filename.mobile" alt="banner">
        <img class="screen-only" :src="img_source + banner.filename.screen" alt="banner">
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
      img_source: 'https://s3-ap-southeast-1.amazonaws.com/images.closet.com/banner/',
      slickOptions: options({
        view: 'full-banner'
      }),
    };
  },
  props: {
    banners: []
  }
}
</script>
