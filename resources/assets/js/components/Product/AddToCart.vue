<template>
<div>
<form name="myform" v-on:submit.prevent="add" method="post">
  <div style="padding: 0px 15px; height:200px">
    <select v-show="choices.length" v-bind:required="choices.length" class="select-input" v-model="selected">
      <option value="" disabled selected>---{{$trans.translation.choice}}---</option>
      <option v-for="choice in choices" :value="choice.name">{{choice.name}}</option>
    </select>
  </div>

  <div v-if="authenticated" class="add-cart">
    <button type="submit" class="add-cart-btn">{{$trans.translation.add_to_cart}}</button>
  </div>
  <div v-else class="add-cart">
    <button type="button" class="add-cart-disabled">{{$trans.translation.add_to_cart}}</button>
    <p>{{$trans.translation.login_first}}&nbsp;<a class="link-text" :href="url + '/login'">{{$trans.translation.login}}</a></p>
  </div>
</form>


</div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      trans: this.$trans,
      url: window.Closet.url,
      product: [],
      choices: [],
      selected: null,
      authenticated: window.Closet.user.authenticated
    }
  },

  props: {
    productId: null,
    productSlug: null,
  },
  methods: {
    ...mapActions([
      'addToCart',
    ]),
    add(){
      this.addToCart({ product: this.product, choice: this.selected });
      toastr.success(this.$trans.translation.added_to_cart);
    },
    getProduct() {
        this.$http.get(this.url + '/cart/get_product/' + this.productSlug).then((response)=> {
            this.product = response.body.data;
        });
    },
    getChoice() {
        this.$http.get(this.url + '/product/' + this.productSlug + '/get_choice').then((response)=> {
            this.choices = response.body;
        });
    }
  },
  mounted(){
    this.getProduct();
    this.getChoice();
  }
}
</script>
