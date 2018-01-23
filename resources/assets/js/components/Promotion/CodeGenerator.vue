<template>
<div>
  <button class="add-col-btn" @click.prevent="formVisible = !formVisible" style="margin-bottom:20px;">{{$trans.translation.add}}</button>
  <transition name="slide-down-height">
  <div class="add-col-panel" style="margin-top:0;" v-show="formVisible">
    <form v-on:submit.prevent="create">
      <div class="form-group">
        <label class="full-label">Code</label>
        <input v-validate="'required|max:10|alpha_num'" class="input-addon-field" type="text" v-model="code" name="code" placeholder="ABC">
        <span v-show="errors.has('code')" class="span-error">{{ errors.first('code') }}</span>
      </div>
      <div class="form-group">
        <div class="input-group">
          <label class="input-addon">{{$trans.translation.discount}}</label>
          <input required v-model="discount" type="number" min="1" class="input-addon-field">
          <select required v-model="type" class="select-input" style="width:100px;">
            <option value="percent">%</option>
            <option value="baht">{{$trans.translation.baht}}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
          <label class="input-addon">{{$trans.translation.amount}}</label>
          <input required v-model="amount" name="amount" type="number" min="1" max="9999" class="input-addon-field">
        </div>
      </div>
      <div class="form-group">
        <table>
          <tr>
            <td class="no-border">
              <button type="submit" class="col-submit float-right" style="position:relative; right:0;">{{$trans.translation.edit_submit}}</button>
            </td>
          </tr>
        </table>
      </div>
    </form>
  </div>
  </transition>

  <table class="c-table">
    <tr>
      <th>Code</th>
      <th>{{$trans.translation.discount}}</th>
      <th>{{$trans.translation.amount}}</th>
      <th>{{$trans.translation.delete}}</th>
    </tr>
    <tr v-for="(code, index) in codes">
      <td class="m-cell overflow-hidden">{{code.code}}</td>
      <td class="s-cell">{{code.discount}}{{code.type == 'percent' ? '%' : ' '+$trans.translation.baht}}</td>
      <td class="s-cell">{{code.amount}}</td>
      <td class="s-cell">
        <button @click.prevent="remove(code.id, index)" class="delete-btn round-btn">
          <small class="icon-bin"></small>
        </button>
      </td>
    </tr>
  </table>
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
      trans: this.$trans,
      formVisible: false,
    }
  },
  methods: {
    getCodes() {
      this.$http.get(this.$root.url + '/profile/promotions/manage/code_get').then((response)=> {
        this.codes = response.body
      });
    },
    create() {
      this.$http.post(this.$root.url + '/profile/promotions/manage/code', {
        code: this.code,
        discount: this.discount,
        amount: this.amount,
        type: this.type,
      }).then((response)=> {
        this.codes.push(response.body)
        toastr.success(this.$trans.translation.success);
      }, (response) => {
          toastr.error(this.$trans.translation.error);
      });
    },
    remove(id, index) {
      if(!confirm(this.$trans.translation.delete_confirm)){
        return
      }
      this.$http.delete(this.$root.url + '/profile/promotions/manage/code/' + id).then((response)=> {
        this.codes.splice(index, 1)
        toastr.success(this.$trans.translation.success);
      }, (response) => {
          toastr.error(this.$trans.translation.error);
      });
    }
  },
  mounted() {
    this.getCodes()
  }
}
</script>
