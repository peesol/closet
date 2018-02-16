<template>
  <div :class="targetElement" ref="el">
    <div v-for="img in imgs">
      <img :src="'https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/photo/' + img.filename" :alt="img.filename">
    </div>
  </div>
</template>

<script>

import Slick from 'slick-carousel/slick/slick.min.js'

export default {
  props: {
    imgs: [],
    targetElement: null,
  },
  mounted(){
    self = this;
    $(self.$refs.el).slick({
      dots: true,
      adaptiveHeight: true
    })
  }
}
</script>
