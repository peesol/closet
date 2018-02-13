<template>
<div style="padding: 20px 0">
  <form v-on:submit.prevent="edit" method="post">
      <label class="full-label">{{$trans.translation.user_info}}</label>
      <div class="form-group">
          <label class="form-label" for="phone">{{$trans.translation.phone}}</label>
          <input v-validate="'required|max:20|numeric'" type="text" :class="{'form-input': true,'is-error': errors.has('phone')}" name="phone" v-model="phone">
          <span v-show="errors.has('phone')" class="span-error">{{ errors.first('phone') }}</span>
      </div>
  <div class="form-group">
      <label class="full-label" for="address">{{$trans.translation.address}}</label>
      <textarea v-validate="'max:500|required'" class="description-input" style="height:150px;" name="address" v-model="address">
      </textarea>
      <span v-show="errors.has('address')" class="span-error">{{ errors.first('address') }}</span>
  </div>
  <div style="position: relative; text-align: right;">
      <button id="submit-all" class="col-photo-submit" style="margin-top:0;">{{$trans.translation.edit_submit}}</button>
  </div>
  </form>
  <div id="full-line" style="margin-top: 20px;"></div>
</div>
</template>

<script>
export default {
	data() {
		return {
      phone: this.$parent.userPhone,
      address: this.$parent.userAddress,
		}
	},
    methods: {
            edit() {
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 2000;

                this.$http.put(this.$root.url + '/' + this.$parent.shopSlug + '/edit/personal_info', {
                    address: this.address,
                    phone: this.phone,
                    }).then((response)=> {
                        this.$Progress.finish();
                        toastr.success(this.$trans.translation.success);
                    }, (response) => {
                        toastr.error(this.$trans.translation.error);
                        this.$Progress.fail();
                    });
            },
    },
}
</script>
