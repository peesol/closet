<template>
<div>
  <button class="orange-btn normal-sq width-120 margin-20-bottom" @click.prevent="formVisible = !formVisible">{{$trans.translation.add}}</button>
  <transition name="slide-down-height">
    <div class="sub-panel shadow-1" v-show="formVisible">
      <form v-on:submit.prevent="create">
        <div class="form-group">
          <label class="full-label input-label">Code</label>
          <input required v-validate="'required|max:10|alpha_num'" class="input-addon-field" type="text" v-model="code" name="code" placeholder="ABC">
          <span v-show="errors.has('code')" class="span-error">{{ errors.first('code') }}</span>
        </div>
        <div class="form-group flex padding-15-vertical">

          <label class="input-label padding-15-right">{{$trans.translation.discount}}</label>
          <input required v-model="discount" type="number" min="1" :max="type == 'percent' ? 99 : null" class="input-addon-field width-120">
          <select required v-model="type" class="select-input">
                <option value="percent">%</option>
                <option value="baht">{{$trans.translation.baht}}</option>
            </select>
        </div>
        <div class="form-group flex">
          <label class="input-label padding-15-right">{{$trans.translation.amount}}</label>
          <input required v-model="amount" name="amount" type="number" min="1" max="9999" class="input-addon-field">
        </div>

        <div class="align-right full-width padding-15-top">
          <button :disabled="$root.loading" type="submit" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
        </div>
      </form>
    </div>
  </transition>
  <div class="padding-15-vertical">
    <table class="c-table" v-show="codes.length">
      <tr>
        <th>Code</th>
        <th>{{$trans.translation.discount}}</th>
        <th class="center">{{$trans.translation.amount}}</th>
        <th class="center">{{$trans.translation.delete}}</th>
      </tr>
      <tr v-for="(code, index) in codes">
        <td class="m-cell overflow-hidden">{{code.code}}</td>
        <td class="s-cell">{{code.discount}}{{code.type == 'percent' ? '%' : ' '+$trans.translation.baht}}</td>
        <td class="s-cell center">{{code.amount}}</td>
        <td class="s-cell center">
          <button @click.prevent="remove(code.id, index)" class="delete-btn round-btn">
            <small class="icon-bin"></small>
          </button>
        </td>
      </tr>
    </table>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      codes: [],
      code: null,
      discount: null,
      amount: null,
      type: null,
      formVisible: false,
    }
  },
  methods: {
    getCodes() {
      this.$http.get(this.$root.url + '/profile/promotions/manage/code_get').then(response => {
        this.codes = response.body
      });
    },
    create() {
      this.$root.loading = true
      this.$http.post(this.$root.url + '/profile/promotions/manage/code', {
        code: this.code,
        discount: this.discount,
        amount: this.amount,
        type: this.type,
      }).then(response => {
        this.code = null
        this.discount = null
        this.amount = null
        this.type = null
        this.$root.loading = false
        this.codes.push(response.body)
        toastr.success(this.$trans.translation.success);
      }, response => {
        this.$root.loading = false
        toastr.error(this.$trans.translation.error);
      });
    },
    remove(id, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return
      }
      this.$http.delete(this.$root.url + '/profile/promotions/manage/code/' + id).then(response => {
        this.codes.splice(index, 1)
        toastr.success(this.$trans.translation.success);
      }, response => {
        toastr.error(this.$trans.translation.error);
      });
    }
  },
  mounted() {
    this.getCodes()
  }
}
</script>
