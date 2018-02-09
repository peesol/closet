<template>
<div>
	<div class="panel-heading" style="border-top:1px solid #efefef"><h4 class="no-margin">{{$trans.translation.photos}}</h4></div>
	<li style="margin: 10px 15px">{{$trans.translation.product_photo_limit}}</li>
		<div v-if="images.length" class="panel-body thumbnail-grid">
			<div v-for="(image, index) in images" class="products-img">
				<img class="full-img" alt="currently uploading..." :src="image.filename">
				<button style="position:absolute;top:5px; right:5px; border-radius: 50%;" @click.prevent="removePhoto(image.id, index)" class="delete-btn"><span class="icon-bin"></span></button>
			</div>
		</div>
		<div id="full-line"></div>
	<div class="panel-heading" id="col-photo-toggle">
		<h4 class="no-margin" @click.prevent="formVisible = !formVisible" style="color:#6c6c6c;cursor:pointer;">{{$trans.translation.upload_photo}}&nbsp&nbsp<span class="icon-arrows-down"></span></h4>
	</div>
	<transition name="slide-down">
		<div v-show="formVisible" style="padding:40px 45px 25px 45px;">
			<p>{{$trans.translation.upload_photo_size}}</p>
    	<div class="dropzone" id="image"><div class="dz-message" data-dz-message><span>{{$trans.translation.upload_photo_guide}}</span></div></div>
    	<div style="text-align:right;">
				<button class="col-photo-submit" @click.prevent="submit" id="photo-submit">{{$trans.translation.upload_submit}}</button>
			</div>
    </div>
  </transition>
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
			dropzoneUrl: this.$root.url + '/product_ajax/' + this.productId + '/img',
		}
	},
	props: {
		productSlug: null,
		productId: null,
	},

    methods: {
			getPhoto() {
  					this.$http.get(this.$root.url + '/product_ajax/' + this.productSlug + '/img/')
  					.then((response) => {return response.json()
						.then((json) => {this.images = json.data;});
					});
  				},

			deleteById(imageId) {
				this.images.map((image, index)=> {
					if (image.id === imageId) {
						this.images.splice(index, 1);
						return;
					}
				});
			},

  			removePhoto(imageId) {
				if(!confirm(this.$trans.translation.photo_delete_confirm)){
					return;
				}
						this.$Progress.start();
						this.$http.delete('/product_ajax/' + imageId + '/img').then(() => {
						this.deleteById(imageId);
						this.$Progress.finish();
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
		    		parallelUploads: 7,
		    		maxFiles: 7,
		    		maxFilesize: 2,
		    		acceptedFiles: '.jpg',
		    		addRemoveLinks: true,
		    		paramName: "image",
						dictRemoveFile: "&times;",
						dictCancelUpload: "&times;",
		    		headers: {'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,},
		    				init: function() {
 							this.on('addedfile', function(file) {
									if (this.files.length + self.images.length > 7 || this.files.length > 7) {
										this.removeFile(this.files[0])
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
    					this.removeFile(this.files[0]);
    					self.$Progress.finish();
    				},
    				error: function() {
    					self.$Progress.fail();
    					toastr.error(self.$trans.translation.error, toastr.options = {"preventDuplicates": true,});
    					this.removeFile(this.files[0]);
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
