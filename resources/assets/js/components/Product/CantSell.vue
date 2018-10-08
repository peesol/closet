<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <div class="padding-30">
    <form v-on:submit.prevent="add" method="post">
      <div>
        <div class="form-group">
          <label class="input-label full-label">{{$trans.translation.account_provider}}</label>
          <select required class="select-input" name="provider" v-model="provider">
            <option v-for="option in options" :value="{'name': option.name, 'code': option.code}">{{option.name}}</option>
          </select>
        </div>
        <div class="form-group">
          <label class="input-label full-label">{{$trans.translation.account_type}}</label>
          <select required class="select-input" name="account_number" v-model="type">
            <option value="Bank">{{$trans.translation.account}}</option>
            <option value="PromptPay">PromptPay</option>
          </select>
        </div>
        <div class="form-group">
          <label class="input-label full-label">{{$trans.translation.account_number}}</label>
          <input maxlength="15" oninput="this.value=this.value.slice(0,this.maxLength)" class="form-input" :placeholder="$trans.translation.numeric_only" type="number" v-validate="'required|numeric|min:10|max:15'" :class="{'is-error': errors.has('account_number')}" v-model="number" name="account_number">
          <span v-show="errors.has('account_number')" class="span-error">{{ errors.first('account_number') }}</span>
        </div>
        <div class="form-group">
          <label class="input-label full-label">{{$trans.translation.account_name}}</label>
          <div class="input-group">
            <input class="form-input" type="text" v-validate="'required'" :class="{'is-error': errors.has('account_name')}" v-model="name" name="account_name">
          </div>
          <span v-show="errors.has('account_name')" class="span-error">{{ errors.first('account_name') }}</span>
        </div>
      </div>
      <div class="align-right padding-15-top">
        <button :disabled="$root.loading || errors.any()" type="submit" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
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
      type: null,
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
  props: {
    shopSlug: null
  },
  methods: {
    add() {
      this.$Progress.start()
      this.$root.loading = true
      toastr.info(this.$trans.translation.wait);
      this.$http.post(this.$root.url + '/manage/account', {
        provider: this.provider,
        number: this.number,
        name: this.name,
        type: this.type,
      }).then(response => {
        this.$Progress.finish()
        this.$root.loading = false
        toastr.success(this.$trans.translation.saved)
        document.location.href = this.$root.url + '/sell/new';
      }, response => {
        this.$Progress.fail()
        this.$root.loading = false
        toastr.error(this.$trans.translation.error)
      });
    },
  },
}
</script>
