<template>
<div>
	<div class="panel-heading" style="border-top:1px solid #efefef"><label class="full-label no-margin">{{$trans.translation.photos}}</label></div>
	<div class="alert-box info">
		<h3 class="no-margin"><span class="icon-notification"></span>&nbsp;{{$trans.translation.col_photo_limit}}</h3>
	</div>
		<div class="panel-body thumbnail-grid" v-if="images.length">
			<div v-for="(image, index) in images" class="products-img">
				<img class="full-img" :alt="image.filename" :src="image.filename">
				<button v-show="image.id && images.length > 1" @click.prevent="remove(image.id, index)" class="caution round-btn red-bg"><span class="icon-bin"></span></button>
			</div>
		</div>
		<div v-else class="panel-body">
			<p class="no-margin">{{$trans.translation.col_photo_none}}</p>
		</div>
		<div id="full-line"></div>
		<div class="panel-heading">
			<label class="full-label no-margin"  style="cursor:pointer" @click.prevent="formVisible = !formVisible">{{$trans.translation.upload_photo}}&nbsp;&nbsp;<small class="icon-arrows-down"></small></label>
		</div>
	<transition name="slide-down">
		<div v-show="formVisible" class="panel-body">
    			<div class="dropzone" id="image"><div class="dz-message" data-dz-message><span>{{$trans.translation.upload_photo_guide}}</span></div></div>
    			<div style="text-align:right;"><button class="col-photo-submit" @click.prevent="submit" id="photo-submit">{{$trans.translation.upload_submit}}</button></div>
    	</div>
    </transition>
		<div id="full-line" v-show="formVisible"></div>
</div>
</template>

<script>
import Dropzone from 'dropzone'
Dropzone.autoDiscover = false
export default {
	data() {
		return {
			images: [],
			formVisible: false,
			dropzoneUrl: this.$root.url + '/collection/' + this.colSlug + '/upload/' + this.colId,
		}
	},
	props: {
		colSlug: null,
		colId: null
	},
    methods: {
			getPhoto() {
  					this.$http.get(this.$root.url + '/collection_ajax/img/' + this.colSlug)
  					.then((response) => {return response.json()
						.then((json) => {this.images = json.data;});
					});
  		},
			remove(imageId, index) {
				if(!confirm(this.$trans.translation.delete_photo_confirm)){
						return;
				}
					this.$http.delete(this.$root.url + '/collection/image/' + imageId).then(() => {
							this.images.splice(index, 1);
							toastr.success(this.$trans.translation.success);
					});
			},

    		initDropzone: function() {
          		self = this;
          		self.$nextTick(function() {
          		self.image = new Dropzone("#image", {
          			method: 'post',
		  			url: self.dropzoneUrl,
		  			autoProcessQueue: false,
		  			uploadMultiple: true,
		    		parallelUploads: 10,
		    		maxFiles: 10,
		    		maxFilesize: 2,
		    		acceptedFiles: '.jpg',
		    		addRemoveLinks: true,
		    		paramName: "image",
						dictRemoveFile: "&times;",
						dictCancelUpload: "&times;",
		    		headers: {'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,},
		    				init: function() {
 							this.on('addedfile', function(file) {
  								if (this.files.length + self.images.length > 10 || this.files.length > 10) {
   									this.removeFile(this.files[0]);
  								}
 								});
					},
    				processing: function() {
							self.$Progress.start();
    				},
    				success: function(file, response) {
							self.images.push({
								id: null,
								filename: file.dataURL,
							})
    					toastr.success(self.$trans.translation.success, toastr.options = {"preventDuplicates": true,});
    					this.removeFile(this.files[0])
    					self.$Progress.finish()
    				},
    				error: function() {
    					self.$Progress.fail()
    					toastr.error(self.$trans.translation.error, toastr.options = {"preventDuplicates": true,})
    					this.removeFile(this.files[0])
    				},
				});
      		});
    	},
    	submit(){
    		self.image.processQueue();
    	}
    },
    created() {
    	this.getPhoto();
    	this.initDropzone();
    }
}
</script>
