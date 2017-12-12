<template>
<div style="padding: 0 15px;">
<div class="col-edit-panel">
  <form v-on:submit.prevent="edit" method="post" enctype="multipart/form-data" class="flex">

    <div class="form-group col-flex">
    <label class="col-label">{{$trans.translation.shipping}}&nbsp;<span style="font-weight:400;">{{$trans.translation.shipping_ex}}</span></label>
    <input v-validate="'max:20'" :class="{'col-edit-input': true,'is-error': errors.has('shipping')}" type="text" v-model="shipping" name="shipping">
  </div>

    <table>
      <tr>
        <td style="width: 160px;"><label class="col-label">{{$trans.translation.shipping_time}}</label></td>
        <td><input  class="s-input" type="number" v-model="shipping_time" name="shipping_time"><span class="col-label" style="margin-left:5px;">{{$trans.translation.days}}</span></td>
      </tr>

      <tr>
        <td><label class="col-label">{{$trans.translation.shipping_free}}</label></td>
        <td>
          <select class="s-select" name="shipping_free" v-model="shipping_free">
            <option value="1">{{$trans.translation.yes}}</option>
            <option value="0">{{$trans.translation.no}}</option>
          </select>
        </td>
      </tr>
      <tr v-show="shipping_free == false">
        <td><label class="col-label">{{$trans.translation.shipping_fee}}</label></td>
        <td><input class="s-input" type="number" v-model="shipping_fee" name="shipping_fee"><span class="col-label" style="margin-left:5px;">{{$trans.translation.baht}}</span></td>
      </tr>
    </table>
    <table>
      <tr>
        <td style="width:100%;"><button class="col-submit float-right" style="position:relative;right:0;" type="submit">{{$trans.translation.edit_submit}}</button></td>
      </tr>
    </table>
  </form>
</div>

</div>

</template>

<script>

export default {
	data() {
		return {
      shipping: this.shippingInfo,
      shipping_fee: this.shippingFee,
      shipping_free: this.shippingFree,
      shipping_time: this.shippingTime,
      shipping_inter: this.shippingInter,
			url: window.Closet.url,
      trans: this.$trans,
		}
	},
	props: {
    shippingInfo: null,
    shippingFree: null,
    shippingFee: null,
    shippingTime: null,
    shippingInter: null,
    productSlug:null
	},

    methods: {
      edit() {
        this.$http.put(this.url + '/product/' + this.productSlug + '/edit/shipping', {
          shipping: this.shipping,
          shipping_fee: this.shipping_fee,
          shipping_free: this.shipping_free,
          shipping_time: this.shipping_time,
          shipping_inter: this.shipping_inter,
        }).then((response)=> {
            toastr.success(this.$trans.translation.saved);
        }, (response) => {
            toastr.error(this.$trans.translation.error);
        });
      },
    },
    created() {
    }
}
</script>
