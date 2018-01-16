<template>
<div>
<vue-progress-bar></vue-progress-bar>
	<button v-show="user_id == shop_user" class="add-col-btn" @click.prevent="formVisible = !formVisible" >{{$trans.translation.add_col}}</button>
	<transition name="slide-down">
	<div id="add-collection" v-show="formVisible">
		<div class="add-col-panel">
		<form v-on:submit.prevent="create">
			<div class="form-group col-flex">
				<label class="full-label" for="name">{{$trans.translation.name}}</label>
				<input required class="col-input" type="text" v-model="name" name="name">
			</div>

			<div class="form-group col-flex">
				<label class="full-label" for="description">{{$trans.translation.description}}</label>
				<input class="col-input" type="text" v-model="description" name="description">
			</div>

			<div class="form-group col-flex">
				<label class="full-label" for="visibility">{{$trans.translation.visibility}}</label>
				<select required class="col-select" v-model="visibility">
					<option value="public">{{$trans.translation.public}}</option>
					<option value="private">{{$trans.translation.private}}</option>
				</select>
				<button class="col-submit" type="submit">{{$trans.translation.create}}</button>
			</div>

		</form>
		</div>
	</div>
	</transition>

	<div class="no-border-heading flex" v-if="collections.length">

			<div class="col-wrap-owner col-margin" v-for="(collection, index) in collections">
				<div class="products-img">
					<a v-bind:href="'/collection/' + collection.slug" class="link-text"><h3 class="col-name">{{ collection.name }}</h3></a>
					<a v-bind:href="'/collection/' + collection.slug">
						<img class="products-img-thumb" v-bind:src="collection.thumbnail">
					</a>
					<span class="private" v-show="collection.visibility === 'private'">{{$trans.translation.private}}</span>
				</div>
				<div v-show="user_id == shop_user">
					<a class="btn absolute margin-top-10px" v-bind:href="'/collection/' + collection.slug + '/edit'" >{{$trans.translation.edit}}</a>
					<button class="danger-btn absolute margin-top-10px" style="margin-left:90px;" @click.prevent="removeCol(collection.slug, index)">{{$trans.translation.delete}}</button>
				</div>
			</div>

	</div>
	<div v-else style="padding: 10px 30px;">
		<h4 class="no-margin">{{$trans.translation.col_none}}</h4>
	</div>
</div>
</template>

<script>
	export default {
		data() {
			return {
				collections: [],
				formVisible: false,
				name: null,
				description: null,
				visibility:null,
				shop_user: this.shopUser,
				collectionSlug: null,
        url: window.Closet.url,
        user_id: window.Closet.user.user,
			}
		},
		props: {
			shopSlug: null,
			shopUser: null
		},
		methods: {
			getCollection() {
  					this.$http.get(this.url + '/collection_ajax/' + this.shopSlug).then((response)=> {
						return response.json()
						.then((json) => {
							this.collections = json.data;
  						});
				});
  			},
			create(){
				this.$Progress.start();
				this.$http.post(this.url + '/collection_ajax/' + this.shopSlug ,{
					name: this.name,
					description: this.description,
					visibility: this.visibility,
				}).then((response)=> {
					this.name = null;
					this.description = null;
					this.visibility = null;
					this.$Progress.finish()
					this.collections.push(response.body)
					toastr.success(this.$trans.translation.col_created, {timeOut: 1000});
				}, (response) => {
	          toastr.error(this.$trans.translation.error);
	      });
			},

			removeCol(collectionSlug, index){
				if(!confirm(this.$trans.translation.col_delete_confirm)){
					return;
				}
				this.$Progress.start();
				this.$http.delete(this.url + '/collection/' + collectionSlug).then(() => {
					this.$delete(this.collections, index)
					this.$Progress.finish()
					toastr.success(this.$trans.translation.col_deleted, {timeOut: 1000})
				}, (response) => {
	          toastr.error(this.$trans.translation.error);
	      });
			},
		},
		created() {
			this.getCollection();
		}
	}
</script>
