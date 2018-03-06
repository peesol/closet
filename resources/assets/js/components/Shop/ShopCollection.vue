<template>
<div class="panel-body-alt">
<vue-progress-bar></vue-progress-bar>
	<div class="margin-bot-10px">
		<button class="orange-btn normal-sq" @click.prevent="formVisible = !formVisible" v-show="user_id == shopUser">{{$trans.translation.add_col}}</button>
	</div>

	<transition name="slide-down">
	<div v-show="formVisible" class="sub-panel shadow-1 margin-top-10px">

		<form v-on:submit.prevent="create">
			<div class="form-group">
				<label class="full-label">{{$trans.translation.name}}</label>
				<input required class="form-input" type="text" v-model="name">
			</div>

			<div class="form-group">
				<label class="full-label">{{$trans.translation.description}}</label>
				<input class="form-input" type="text" v-model="description">
			</div>

			<div class="form-group">
				<label class="full-label">{{$trans.translation.visibility}}</label>
				<select required class="select-input" v-model="visibility">
					<option value="public">{{$trans.translation.public}}</option>
					<option value="private">{{$trans.translation.private}}</option>
				</select>
			</div>

			<div class="align-right padding-15-vertical" style="padding-bottom:5px">
				<button class="orange-btn normal-sq" type="submit">{{$trans.translation.create}}</button>
			</div>

		</form>

	</div>
	</transition>

	<div class="thumbnail-grid padding-30-vertical" v-if="collections.length">

			<div class="" v-for="(collection, index) in collections">
				<div class="products-img">
					<div class="thumb-title">
						<a v-bind:href="'/collection/' + collection.slug" class="link-text">{{ collection.name }}</a>
					</div>
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
	<div v-else>
		<div class="panel-body">
			<h4 class="no-margin">{{$trans.translation.col_none}}</h4>
		</div>
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
