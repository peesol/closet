<template>
<div>
<vue-progress-bar></vue-progress-bar>
                    <button class="add-col-btn" @click.prevent="formVisible = !formVisible" >{{$trans.translation.add}}</button>
                    <transition name="slide-down-height">
                      <div style="padding: 20px;" v-show="formVisible">
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
                    </transition>

                    <div v-for="(account, index) in accounts" class="round-div margin-top-10px" v-show="accounts.length">
                      <table class="c-table">
                        <tr>
                          <td id="icon" colspan="1"><span :class="'icon-'+account.provider"></span></td>
                          <td colspan="3" class="overflow-hidden"><h4 class="no-margin">{{account.provider_name}}</h4></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td class="m-cell"><h4 class="no-margin">{{account.number}}</h4></td>
                          <td class="m-cell overflow-hidden"><p class="no-margin">{{account.name}}</p></td>
                          <td class="s-cell"><button type="button" @click.prevent="remove(account.id, index)" class="delete-btn round-btn float-right"><small class="icon-bin"></small></button></td>
                        </tr>
                      </table>
                    </div>

                <div v-show="!accounts.length" style="padding-left: 15px;"><h4>{{$trans.translation.no_account}}</h4></div>


</div>
</template>

<script>
export default {
	data() {
		return {
      accounts: [],
      provider: null,
      number: null,
      name: null,
      formVisible: false,
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
            getAccounts() {
              this.$Progress.start()
              this.$http.get(this.$root.url + '/' + this.$route.params.shop + '/edit/account').then((response) => {
                this.accounts = response.body
                this.$Progress.finish()
              });
            },
            add() {
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 2000;
                    this.$Progress.start()
                    toastr.info(this.$trans.translation.wait);
                    this.$http.post(this.$root.url + '/' + this.$route.params.shop + '/edit/account', {
                    provider: this.provider,
                    number: this.number,
                    name: this.name,
                    }).then((response)=> {
                        this.$Progress.finish()
                        toastr.success(this.$trans.translation.saved)
                        this.accounts.push(response.body)
                        this.provider = null;
                        this.number = null;
                        this.name = null;
                    }, (response) => {
                        toastr.error(this.$trans.translation.error)
                        this.$Progress.fail()
                    });
            },
            remove(accountId, index){
              if(!confirm(this.$trans.translation.delete_confirm)){
                return
              }
              this.$http.delete(this.$root.url + '/' + this.$route.params.shop + '/edit/account/' + accountId + '/delete').then((response)=> {
                  toastr.success(this.$trans.translation.success)
                  this.$delete(this.accounts, index)
                  if (!this.accounts.length) {
                    this.$http.put(this.$root.url + '/' + this.$route.params.shop + '/edit/set_sell_status')
                  }
              }, (response) => {
                  toastr.error(this.$trans.translation.error)
              });
            }
    },
    created() {
      this.getAccounts()
    },
}
</script>
