<template>
<div>
<vue-progress-bar></vue-progress-bar>
                    <div style="padding: 20px;">
                        <form v-on:submit.prevent="add" method="post">
                        <div>
                            <div class="form-group">
                                     <label class="full-label" style="padding: 0;">{{$trans.translation.account_provider}}</label>
                                     <select required class="select-input" name="provider" v-model="provider">
                                        <option v-for="option in options" :value="{'name': option.name, 'code': option.code}">{{option.name}}</option>
                                      </select>
                            </div>
                            <div class="form-group">
                              <label class="full-label">{{$trans.translation.account_number}}</label>
                                 <div class="input-group" style="margin-bottom:8px;">
                                     <input type="text" v-validate="'required|numeric|min:10|max:12'" :class="{'input-addon-field': true,'is-error': errors.has('account_number')}" v-model="number" name="account_number">
                                 </div>
                                 <span v-show="errors.has('account_number')" class="span-error">{{ errors.first('account_number') }}</span>
                            </div>

                            <div class="form-group">
                              <label class="full-label">{{$trans.translation.account_name}}</label>
                                 <div class="input-group" style="margin-bottom:8px;">
                                     <input type="text" v-validate="'required'" :class="{'input-addon-field': true,'is-error': errors.has('account_name')}" v-model="name" name="account_name">
                                 </div>
                                 <span v-show="errors.has('account_name')" class="span-error">{{ errors.first('account_name') }}</span>
                            </div>
                        </div>
                        <div style="position: relative; text-align: right;">
                            <button id="submit-all" class="col-photo-submit" style="margin-top:0;">{{$trans.translation.edit_submit}}</button>
                        </div>
                        </form>
                    </div>
</div>
</template>

<script>
export default {
	data() {
		return {
      provider: null,
      number: null,
      name: null,
      
			url: window.Closet.url,
      locale: window.Closet.locale,
      options: [
        {'name':'ธนาคารกรุงเทพ', 'code':'BBL'},
        {'name':'ธนาคารกสิกรไทย', 'code':'KBANK'},
        {'name':'ธนาคารกรุงไทย', 'code':'KTB'},
        {'name':'ธนาคารไทยพาณิชย์', 'code':'SCB'},
        {'name':'ธนาคารทหารไทย', 'code':'TMB'},
        {'name':'ธนาคารออมสิน', 'code':'GSB'},
        {'name':'ธนาคารกรุงศรีอยุธยา', 'code':'BAY'},
      ],
		}
	},
    methods: {
      add() {
        toastr.options.preventDuplicates = true;
        toastr.options.timeOut = 2000;
          this.$Progress.start()
          toastr.info(this.$trans.translation.wait);
          this.$http.post(this.url + '/' + this.$root.shopSlug + '/edit/account', {
          provider: this.provider,
          number: this.number,
          name: this.name,
          }).then((response)=> {
              this.$Progress.finish()
              toastr.success(this.$trans.translation.saved)
              document.location.href= this.url + '/sell/product';
          }, (response) => {
              toastr.error(this.$trans.translation.error)
              this.$Progress.fail()
          });
      },
    },
}
</script>
