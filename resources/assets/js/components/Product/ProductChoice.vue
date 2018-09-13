<template>
<div class="padding-15-top padding-30" id="full-line">

  <div class="half-width-res">
    <form>
      <label for="name" class="full-label input-label">{{$trans.translation.choice_add}}&nbsp;
        <span class="font-light">{{$trans.translation.choice_name_ex}}</span>
      </label>
      <div class="input-group">
        <input class="input-addon-field" type="text" v-model="name" name="name">
        <button :disabled="$root.loading" class="input-addon checkmark-btn icon-checkmark" type="submit" @click.prevent="add"></button>
      </div>
    </form>
  </div>

  <div class="" v-if="choices.length">
    <label class="full-label input-label padding-15-vertical">{{$trans.translation.current_choices}}</label>
    <table class="c-table">
      <tr>
        <th>{{$trans.translation.choice}}</th>
        <th>{{$trans.translation.show}}</th>
        <th class="center">{{$trans.translation.delete}}</th>
      </tr>
      <tr v-for="(choice, index) in choices">
        <td class="m-cell overflow-hidden" style="width:100%;">{{choice.name}}</td>
        <td class="s-cell">
          <button @click.prevent="toggleChoice(choice.id, index)" class="round-btn font-white" :class="{'green-bg' : choice.stock, 'red-bg' : !choice.stock}">
            <small :class="{'icon-checkmark' : choice.stock, 'icon-cross' : !choice.stock}"></small>
          </button>
        </td>
        <td class="s-cell">
          <button @click.prevent="remove(choice.id, index)" class="delete-btn round-btn">
              <small class="icon-bin"></small>
          </button>
        </td>
      </tr>
    </table>
  </div>

  <div v-else></div>

</div>
</template>

<script>
export default {
  data() {
    return {
      choices: [],
      name: null
    }
  },

  props: {
    productSlug: null,
  },

  methods: {
    getChoice() {
      this.$http.get(this.$root.url + '/product/' + this.productSlug + '/get_choice').then((response) => {
        this.choices = response.body;
      });
    },

    add() {
      this.$root.loading = true
      this.$http.post(this.$root.url + '/product/' + this.productSlug + '/create', {
        name: this.name
      }).then(response => {
        this.name = null
        this.$requestTimer(2000)
        this.choices.push(response.body)
        toastr.success(this.$trans.translation.saved)
      }, response => {
        this.$root.loading = false
        toastr.error(this.$trans.translation.error)
      });
    },

    toggleChoice(choiceId, index) {
      this.$http.put(this.$root.url + '/product/' + this.productSlug + '/toggle_choice', {
        id: choiceId
      }).then(response => {
        toastr.success(this.$trans.translation.saved)
        if (this.choices[index].stock) {
          this.$set(this.choices[index], 'stock', false)
        } else {
          this.$set(this.choices[index], 'stock', true)
        }
      }, response => {
        toastr.error(this.$trans.translation.error)
      });
    },

    remove(choiceId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url + '/product/' + this.productSlug + '/choice/delete/' + choiceId).then(() => {
        this.choices.splice(index, 1)
        toastr.success(this.$trans.translation.success, toastr.options = {
          "preventDuplicates": true,
        });
      });
    },

  },

  created() {
    this.getChoice();
  }

}
</script>
