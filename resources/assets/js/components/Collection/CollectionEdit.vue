<template>
<div style="padding: 0 30px;">
<vue-progress-bar></vue-progress-bar>
		<form v-on:submit.prevent="edit" method="post" enctype="multipart/form-data" class="flex">
			<div class="add-col-panel flex">
				<div class="image-input">
				<span class="icon-images"></span>
				<img class="image-input-img" :src="image_filename">
				</div>
				<ul style="list-style-type: none; padding: 0; margin: 0;">
				<li><div class="image-file-input">
				<input id="image-input" class="image-input-input" @change="previewThumbnail" type="file" :name="image_filename" accept="image/*">
				<p style="padding:12px; text-align:center;">{{$trans.translation.choose_file}}</p>
				</div></li>
				<li><button class="image-file-input" v-if="image_filename !== null" @click.prevent="removeFile">{{$trans.translation.remove}}</button></li>
				</ul>
			</div>
		<div class="col-edit-panel">
			<div class="form-group col-flex">
				<label class="full-label" for="name">{{$trans.translation.col_name}}</label>
				<input v-validate="'required|min:3|max:50'" :class="{'col-edit-input': true,'is-error': errors.has('name')}" type="text" v-model="name" name="name">
				<span v-show="errors.has('name')" class="span-error">{{ errors.first('name') }}</span>
			</div>
			<div class="form-group col-flex">
				<label class="full-label" for="description">{{$trans.translation.description}}</label>
				<input class="col-edit-input" type="text" v-model="description" name="description">
			</div>
			<div class="form-group col-flex">
				<label class="full-label" for="visibility">{{$trans.translation.visibility}}</label>
				<select required class="col-select" v-model="visibility" selected="colVisibility">
					<option value="public">{{$trans.translation.public}}</option>
					<option value="private">{{$trans.translation.private}}</option>
				</select>
				<button class="col-submit" type="submit">{{$trans.translation.edit_submit}}</button>
			</div>
		</div>
		</form>
</div>

</template>

<script>
	export default {
		data() {
			return {
				image_filename: this.imageSrc,
				name: this.colName,
				description: this.colDescription,
				visibility:this.colVisibility,
			}
		},
		props: {
			colName:null,
			colDescription:null,
			colVisibility:null,
			imageSrc: null,
		},
		methods: {
			edit() {
				if(document.getElementById("image-input").files.length == 0) {
					this.$Progress.start();
					toastr.info(this.$trans.translation.wait);
					this.$http.put(this.$root.url + '/collection/' + this.$root.colSlug + '/edit', {
					name: this.name,
					description: this.description,
					visibility: this.visibility,
					}).then((response)=> {
						this.$Progress.finish();
						toastr.success(this.$trans.translation.success);
    				}, (response) => {
            toastr.error(this.$trans.translation.error);
            this.$Progress.fail();
      			});
				}
				if(document.getElementById("image-input").files.length > 0){
					this.$Progress.start();
					toastr.info(this.$trans.translation.wait);
  				this.$http.put(this.$root.url + '/collection/' + this.$root.colSlug + '/edit', {
					name: this.name,
					description: this.description,
					visibility: this.visibility,
					thumbnail: this.image_filename,
					}).then((response)=> {
						this.$Progress.finish();
						toastr.success(this.$trans.translation.success);
    				}, (response) => {
            toastr.error(this.$trans.translation.error);
            this.$Progress.fail();
      			});
				}
			},
			previewThumbnail(event) {
            	var input = event.target;
            		if (input.files && input.files[0]) {
                		var reader = new FileReader();
                		var vm = this;
                	reader.onload = function(e) {
                    	vm.image_filename = e.target.result;
                	}
                	reader.readAsDataURL(input.files[0]);
            	}
        	},
        	removeFile() {
        		this.image_filename = null;
        	},

		},
	}
</script>
