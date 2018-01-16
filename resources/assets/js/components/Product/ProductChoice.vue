<template>

<div>
  <div style="padding: 0px 15px 10px 15px">
    <div class="add-col-panel">
		<form>
      <label for="name" class="full-label">{{$trans.translation.choice_add}}&nbsp;<span style="font-weight:400;">{{$trans.translation.choice_name_ex}}</span></label>
        <div class="input-group">
				<input class="input-addon-field" type="text" v-model="name" name="name">
        <button class="input-addon" style="border: none;" type="submit" @click.prevent="add"><span class="icon-checkmark"></span></button>
        </div>
		</form>
		</div>

    <div style="padding:15px;" v-if="choices.length">
      <h4>{{$trans.translation.current_choices}}</h4>
      <table class="c-table">
        <tr>
          <th>{{$trans.translation.choice}}</th>
          <th>{{$trans.translation.show}}</th>
          <th>{{$trans.translation.delete}}</th>
        </tr>
        <tr v-for="choice in choices">
          <td class="m-cell overflow-hidden" style="width:100%;">{{choice.name}}</td>
          <td class="s-cell">
            <button @click.prevent="toggleChoice(choice.id)" class="round-btn" v-bind:class="{ 'red-bg': choice.stock == true, 'green-bg': choice.stock == false}">
              <small v-bind:class="{ 'icon-cross': choice.stock == true, 'icon-checkmark': choice.stock == false}"></small>
            </button>
          </td>
          <td class="s-cell">
            <button @click.prevent="remove(choice.id)" class="red-bg round-btn">
              <small style="margin-left: 3px;" class="icon-bin"></small>
            </button>
          </td>
        </tr>
      </table>
    </div>

    <div v-else></div>

  </div>
</div>

</template>

<script>
	export default{
		data() {
			return {
        choices: [],
        name: null,
        status: null,
        url: window.Closet.url,
        user_id: window.Closet.user.user,
				trans: this.$trans,
			}
		},

		props: {
      productId: null,
		},

		methods: {
      getChoice() {
          this.$http.get(this.url + '/product_ajax/' + this.productId + '/choice').then((response)=> {
          this.choices = response.body;
        });
      },

      add(){
        this.$http.post(this.url + '/product_ajax/' + this.productId + '/choice', {
          name: this.name
        }).then((response)=> {
              this.getChoice();
        }, (response) => {
            toastr.error(this.$trans.translation.error);
        });
      },

      toggleChoice(choiceId){
        this.$http.put(this.url + '/product_ajax/' + this.productId + '/choice', {
          id: choiceId
        }).then((response)=> {
              this.getChoice();
        }, (response) => {
            toastr.error(this.$trans.translation.error);
        });
      },

      remove(choiceId) {
      if(!confirm(this.$trans.translation.delete_confirm)){
        return;
      }
        this.$http.delete(this.url + '/product_ajax/delete/choice/' + choiceId).then(() => {
          this.getChoice();
          toastr.success(this.$trans.translation.success, toastr.options = {"preventDuplicates": true,});
        });
      },

    },

    created() {
      this.getChoice();
  	}

	}
</script>
