<template>
<div>
<vue-progress-bar></vue-progress-bar>
	<button class="add-col-btn" @click.prevent="formVisible = !formVisible" v-show="user_id == shopUser">{{$trans.translation.add_col}}</button>
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

	<div class="thumbnail-grid margin-top-10px" v-if="collections.length">

			<div class="" v-for="(collection, index) in collections">
				<div class="products-img" style="white-space:nowrap;">
					<a v-bind:href="'/collection/' + collection.slug" class="link-text"><h3 class="col-name">{{ collection.name }}</h3></a>
					<a v-bind:href="'/collection/' + collection.slug">
						<img class="products-img-thumb" v-bind:src="collection.thumbnail">
					</a>
					<span class="private icon-private" v-show="collection.visibility === 'private'"></span>
				</div>
				<div v-show="user_id == shopUser" style="padding: 10px 5px;" id="full-line">
					<button class="round-btn edit-btn"  @click.prevent="edit(collection.slug)">
						<small class="icon-cog"></small>
					</button>
					<button class="round-btn delete-btn" @click.prevent="removeCol(collection.slug, index)">
						<small class="icon-bin"></small>
					</button>
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
					this.$Progress.start();
  					this.$http.get(this.$root.url + '/collection_ajax/' + this.shopSlug).then((response)=> {
							this.collections = response.body.data
							this.$Progress.finish()
						});
  			},
			create(){
				this.$Progress.start();
				this.$http.post(this.$root.url + '/collection_ajax/' + this.shopSlug ,{
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
			edit(collectionSlug){
				document.location.href= this.$root.url + '/collection/' + collectionSlug + '/edit';
			},
			removeCol(collectionSlug, index){
				if(!confirm(this.$trans.translation.col_delete_confirm)){
					return;
				}
				this.$Progress.start();
				this.$http.delete(this.$root.url + '/collection/' + collectionSlug).then(() => {
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
