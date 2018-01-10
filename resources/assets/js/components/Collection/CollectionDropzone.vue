<template>
<div>
	<div class="panel-heading" style="border-top:1px solid #efefef"><h3 class="no-margin">{{$trans.translation.photos}}</h3></div>
	<div class="panel-heading" v-show="images.length >= 10"><p class="no-margin">{{$trans.translation.col_photo_limit}}</p></div>
		<div class="panel-body thumbnail-grid" v-if="images.length">
			<div v-for="(image, index) in images" class="products-img">
				<img class="full-img" :alt="image.filename" :src="image.filename"><button style="position:absolute;top:5px; right:5px; border-radius: 50%;" @click.prevent="removePhoto(image.id, index)" class="delete-btn"><span class="icon-bin"></span></button>
			</div>
		</div>
		<div v-else class="panel-body">
			<p class="no-margin">{{$trans.translation.col_photo_none}}</p>
		</div>
		<div id="full-line"></div>
	<div class="panel-heading">
		<h4 @click.prevent="formVisible = !formVisible" class="no-margin" style="color:#6c6c6c; cursor:pointer;">{{$trans.translation.upload_photo}}&nbsp&nbsp<span class="icon-arrows-down"></span></h4>
	</div>
	<transition name="slide-down">
		<div v-show="formVisible" style="padding:40px 45px 25px 45px;">
    			<div class="dropzone" id="image"><div class="dz-message" data-dz-message><span>{{$trans.translation.upload_photo_guide}}</span></div></div>
    			<div style="text-align:right;"><button class="col-photo-submit" @click.prevent="submit" id="photo-submit">{{$trans.translation.upload_submit}}</button></div>
    	</div>
    </transition>
		<div id="full-line" v-show="formVisible"></div>
</div>
</template>

<script>
import Dropzone from 'dropzone'
//import jQuery from 'jquery'
Dropzone.autoDiscover = false
export default {
	data() {
		return {
			images: [],
			formVisible: false,
			dropzoneUrl: window.Closet.url + '/collection/' + this.$root.colSlug + '/upload/' + this.$root.colId,
			url: window.Closet.url,
		}
	},
    methods: {
			getPhoto() {
  					this.$http.get(this.url + '/collection_ajax/img/' + this.$root.colSlug)
  					.then((response) => {return response.json()
						.then((json) => {this.images = json.data;});
					});
  				},
			removePhoto(imageId, index) {
				if(!confirm(this.$trans.translation.delete_photo_confirm)){
						return;
				}
					this.$http.delete(this.url + '/collection/image/' + imageId).then(() => {
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
						sendingmultiple: function(){
							var list = document.getElementsByClassName("dz-image");
							for (var i = 0; i < list.length; i++) {
								var img = list[i].getElementsByTagName('img')[0].getAttribute('src');
										self.images.push({filename: img})
								}
						},
    				success: function() {
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
