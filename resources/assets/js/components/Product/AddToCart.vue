<template>
<div class="relative">
  <vue-progress-bar></vue-progress-bar>
  <load-overlay bg="white-bg" :show="!choiceLoaded"></load-overlay>
<form name="myform" @submit.prevent="add">
  <div class="choice-wrapper">
    <label v-show="choices.length" class="full-label input-label margin-10-bottom">{{$trans.translation.choice}}</label>
    <select v-show="choices.length" v-bind:required="choices.length >= 1" class="select-input" v-model="selected">
      <option v-for="choice in choices" :value="choice.name">{{choice.name}}</option>
    </select>
  </div>

  <div v-if="$root.authenticated" class="add-cart">
    <button v-show="productLoaded && choiceLoaded" type="submit" class="add-cart-btn">{{$trans.translation.add_to_cart}}</button>
  </div>
  <div v-else class="add-cart">
    <button type="button" class="add-cart-disabled">{{$trans.translation.add_to_cart}}</button>
    <p>{{$trans.translation.login_first}}&nbsp;<a class="link-text" :href="$root.url + '/login'">{{$trans.translation.login}}</a></p>
  </div>
</form>


</div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      product: [],
      choices: [],
      selected: null,
      productLoaded: false,
      choiceLoaded: false,
    }
  },

  props: [
    'productSlug',
    'productStock'
  ],
  methods: {
    ...mapActions([
      'addToCart',
    ]),
    add(){
      this.addToCart({
        product: this.product,
        choice: this.selected ,
        stock: this.productStock
      });
      toastr.success(this.$trans.translation.added_to_cart);
    },
    getProduct() {
        this.$http.get(this.$root.url + '/cart/get_product/' + this.productSlug).then((response)=> {
            this.product = response.body.data;
            this.productLoaded = true
        });
    },
    getChoice() {
      this.$Progress.start();
        this.$http.get(this.$root.url + '/product/' + this.productSlug + '/get_choice').then((response)=> {
            this.choices = response.body;
            this.choiceLoaded = true
            this.$Progress.finish();
        });
    }
  },
  created(){
    if (this.$root.authenticated) {
      this.getProduct()
      this.getChoice()
    }
  }
}
</script>
