<template>
<div class="panel-body relative">
  <vue-progress-bar></vue-progress-bar>
  <div class="padding-15-bottom">
    <button class="orange-btn normal-sq width-120" @click.prevent="formVisible = !formVisible">{{$trans.translation.add}}</button>
  </div>

  <transition name="slide-down-height">
    <div v-show="formVisible">
      <form v-on:submit.prevent="add" method="post" class="panel-body shadow-2">
        <div>
          <div class="form-group margin-10-bottom">
            <label class="full-label input-label" style="padding: 0;">{{$trans.translation.account_provider}}</label>
            <select required class="select-input" name="provider" v-model="provider">
              <option v-for="option in options" :value="{'name': option.name, 'code': option.code}">{{option.name}}</option>
            </select>
          </div>
          <div class="form-group">
            <label class="full-label input-label">{{$trans.translation.account_number}}</label>
            <input type="text" class="form-input" v-validate="'required|numeric|min:10|max:12'" :class="{'is-error': errors.has('account_number')}" v-model="number" name="account_number">
            <span v-show="errors.has('account_number')" class="span-error">{{ errors.first('account_number') }}</span>
          </div>
          <div class="form-group">
            <label class="full-label input-label">{{$trans.translation.account_name}}</label>
            <input type="text" class="form-input" v-validate="'required'" :class="{'is-error': errors.has('account_name')}" v-model="name" name="account_name">
            <span v-show="errors.has('account_name')" class="span-error">{{ errors.first('account_name') }}</span>
          </div>
        </div>
        <div class="align-right padding-15-top">
          <button :disabled="$root.loading" type="submit" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
        </div>
      </form>
    </div>
  </transition>

  <div v-for="(account, index) in accounts" class="shadow-2 margin-20-top" v-show="accounts.length">
    <div class="color-heading grey-bg">
      <label class="full-label input-label">{{account.provider_name}}</label>
    </div>
    <div class="padding-15-top padding-15-horizontal">
      <label class="full-label heading margin-10-bottom">{{account.name}}</label>
      <label class="full-label input-label font-green">{{account.number}}</label>
    </div>
    <div class="align-right panel-body">
      <button v-show="accounts.length > 1" type="button" @click.prevent="remove(account.id, index)" class="flat-btn delete font-15em">
        <i class="fas fa-trash-alt"></i>
      </button>
    </div>
  </div>

  <div v-show="!accounts.length" class="padding-15-vertical align-center">
    <h2 class="font-grey">{{$trans.translation.no_account}}</h2>
  </div>

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
      options: [{
          'name': 'ธนาคารกรุงเทพ',
          'code': 'BBL'
        },
        {
          'name': 'ธนาคารกสิกรไทย',
          'code': 'KBANK'
        },
        {
          'name': 'ธนาคารกรุงไทย',
          'code': 'KTB'
        },
        {
          'name': 'ธนาคารไทยพาณิชย์',
          'code': 'SCB'
        },
        {
          'name': 'ธนาคารทหารไทย',
          'code': 'TMB'
        },
        {
          'name': 'ธนาคารออมสิน',
          'code': 'GSB'
        },
        {
          'name': 'ธนาคารกรุงศรีอยุธยา',
          'code': 'BAY'
        },
      ],
    }
  },
  methods: {
    getAccounts() {
      this.$Progress.start()
      this.$root.loading = true
      this.$http.get(this.$root.url + '/' + this.$route.params.shop + '/edit/account/get').then(response => {
        this.accounts = response.body
        this.$Progress.finish()
        this.$root.loading = false
      });
    },
    add() {
      toastr.options.preventDuplicates = true;
      toastr.options.timeOut = 2000;
      this.$Progress.start()
      this.$root.loading = true
      toastr.info(this.$trans.translation.wait);
      this.$http.post(this.$root.url + '/' + this.$route.params.shop + '/edit/account', {
        provider: this.provider,
        number: this.number,
        name: this.name,
      }).then(response => {
        this.$Progress.finish()
        this.$root.loading = false
        toastr.success(this.$trans.translation.saved)
        this.accounts.push(response.body)
        this.provider = null;
        this.number = null;
        this.name = null;
      }, response => {
        this.$Progress.fail()
        this.$root.loading = false
        toastr.error(this.$trans.translation.error)
      });
    },
    remove(accountId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return
      }
      this.$http.delete(this.$root.url + '/' + this.$route.params.shop + '/edit/account/' + accountId + '/delete').then(response => {
        toastr.success(this.$trans.translation.success)
        this.$delete(this.accounts, index)
      }, response => {
        toastr.error(this.$trans.translation.error)
      });
    }
  },
  created() {
    this.getAccounts()
  },
}
</script>
