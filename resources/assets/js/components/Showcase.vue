<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <button class="add-col-btn" @click.prevent="formVisible = !formVisible">{{$trans.translation.create_showcase}}</button>
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
    <div v-show="showcases.length" class="alert-box info">
      <h3 class="no-margin"><span class="icon-notification"></span>&nbsp;{{$trans.translation.showcase_drag}}</h3>
    </div>
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
              <label>{{$trans.translation.show_cover}}</label>&nbsp;<small v-bind:class="{ 'icon-checkmark green-font': showcase.show == true, 'icon-cross red-font': showcase.show == false}"></small>
              <button class="round-sq-btn" @click.prevent="showToggle(showcase.id, index)">{{showcase.show ? $trans.translation.hide : $trans.translation.show}}</button>
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
			}
		},
    components: {
      draggable,
    },

		props: {
			shopSlug: null,
		},

		methods: {
      getShowcase() {
          this.$Progress.start()
          this.$http.get(this.$root.url + '/' + this.shopSlug + '/edit/showcase/get').then((response)=> {
            this.showcases = response.body;
            this.$Progress.finish()
        });
      },
      create(index){
        this.$Progress.start()
				this.$http.post(this.$root.url + '/' +this.shopSlug + ' /edit/showcase/create' ,{
					name: this.name,
          order: this.showcases.length ? this.showcases.length + 1 : 1
				}).then((response)=> {
							this.name = null;
  						this.showcases.push(response.body)
  						toastr.success(this.$trans.translation.showcase_created);
              this.$Progress.finish()
				}, (response) => {
          this.$Progress.fail()
            toastr.error(this.$trans.translation.error);
        });
			},

      remove(showcaseId, index) {
      if(!confirm(this.$trans.translation.delete_confirm)){
        return;
      }
        this.$http.delete(this.$root.url + '/' +this.shopSlug + '/edit/showcase/' + showcaseId + '/delete').then(() => {
          this.showcases.splice(index, 1)
          toastr.success(this.$trans.translation.success, toastr.options = {"preventDuplicates": true,});
        });
      },

      edit(showcaseId){
        document.location.href= this.$root.url + '/' +this.shopSlug + '/edit/showcase/' + showcaseId + '/edit';
      },

      showToggle(showcaseId, index){
        this.$http.put(this.$root.url + '/' +this.shopSlug + '/edit/showcase/' + showcaseId + '/toggle_show' ).then((response) => {
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
        this.$http.put(this.$root.url + '/' +this.shopSlug + '/edit/showcase/order/update', {
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
