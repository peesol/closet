<template>

<div>
  <button v-if="user_id == shop_user" class="add-col-btn" @click.prevent="formVisible = !formVisible">{{$trans.translation.create_showcase}}</button>
	<transition name="slide-down-showcase">
	<div v-show="formVisible" style="height: 175px;">
		<div class="add-col-panel">
		<form v-on:submit.prevent="create">
			<div class="form-group col-flex">
				<label class="full-label" for="name">{{$trans.translation.name}}</label>
				<input required class="col-input" type="text" v-model="name" name="name">
			</div>
				<button class="col-submit" type="submit" >{{$trans.translation.create}}</button>
		</form>
		</div>
	</div>
	</transition>
  <div class="margin-top-10px">
    <li v-show="showcases.length" style="padding: 15px;">{{$trans.translation.showcase_drag}}</li>
      <draggable :list="showcases" :options="{animation: 200, handle: '.showcase-handle'}" @change="order">
      <div class="round-div" v-for="(showcase, index) in showcases" v-show="showcases.length">
        <table class="c-table">
          <tr>
            <td class="m-cell overflow-hidden" style="width:100%;"><label>{{showcase.name}}</label></td>
            <td class="s-cell"><button class="edit-btn showcase-handle round-btn"><span>{{showcase.order}}</span></button></td>
            <td class="s-cell"><button @click.prevent="edit(showcase.id)" class="edit-btn round-btn"><small class="icon-cog"></small></button></td>
            <td class="s-cell"><button @click.prevent="remove(showcase.id, index)" class="delete-btn round-btn"><small class="icon-bin"></small></button></td>
          </tr>
          <tr>
            <td colspan="4">
              <label>{{$trans.translation.showcase_choice}}</label>&nbsp;<small v-bind:class="{ 'icon-checkmark green-font': showcase.show == true, 'icon-cross red-font': showcase.show == false}"></small>
              <button class="round-sq-btn" type="submit" @click.prevent="showToggle(showcase.id, index)">{{showcase.show ? $trans.translation.hide : $trans.translation.show}}</button>
            </td>
          </tr>
        </table>
      </div>
      </draggable>
      <div style="padding-left: 15px;" v-show="!showcases.length"><h4>{{$trans.translation.no_showcase}}</h4></div>

  </div>
</div>
</template>

<script>
  import draggable from 'vuedraggable'

	export default{
		data() {
			return {
        name: null,
        products: null,
        showcases: [],
        formVisible: false,
        shop_user: this.shopId,
        url: window.Closet.url,
        user_id: window.Closet.user.user,
				
			}
		},
    components: {
      draggable,
    },

		props: {
			shopId: null,
		},

		methods: {
      getShowcase() {
          this.$http.get(this.url + '/showcase_ajax/' + this.$root.shopSlug + '/showcase').then((response)=> {
          return response.json()
          .then((json) => {
            this.showcases = json;
            });
        });
      },
      create(index){
				this.$http.post(this.url + '/showcase_ajax/' + this.$root.shopSlug + '/showcase' ,{
					name: this.name,
          order: this.showcases.length ? this.showcases.length + 1 : 1
				}).then((response)=> {
							this.name = null;
  						this.showcases.push(response.body)
  						toastr.success(this.$trans.translation.showcase_created);
				}, (response) => {
            toastr.error(this.$trans.translation.error);
        });
			},

      remove(showcaseId, index) {
      if(!confirm(this.$trans.translation.delete_confirm)){
        return;
      }
        this.$http.delete(this.url + '/showcase_ajax/delete/' + showcaseId).then(() => {
          this.showcases.splice(index, 1)
          toastr.success(this.$trans.translation.success, toastr.options = {"preventDuplicates": true,});
        });
      },

      edit(showcaseId){
        document.location.href= this.url + '/profile/showcase/' + showcaseId + '/edit';
      },

      showToggle(showcaseId, index){
        this.$http.put(this.url + '/showcase_ajax/show/' + showcaseId ).then((response) => {
            toastr.success(this.$trans.translation.saved);
            if (this.showcases[index].show) {
              this.$set(this.showcases[index], 'show', false)
            } else {
              this.$set(this.showcases[index], 'show', true)
            }
        }, (response) => {
            toastr.error(this.$trans.translation.error);
        });
      },

      order(){
        this.showcases.map((showcase, index) => {
          showcase.order = index + 1;
        });
        this.$http.put(this.url + '/showcase_ajax/update/all/order', {
          showcases: this.showcases
        }).then((response) => {
            toastr.success(this.$trans.translation.saved);
        }, (response) => {
            toastr.error(this.$trans.translation.error);
        });
      }

    },

    created() {
      this.getShowcase();
  	}

	}
</script>
