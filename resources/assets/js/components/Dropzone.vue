<template>
<div>
	<label class="col-label">Collection photo</label>
    <div class="dropzone" id="image"></div>
    <button class="col-photo-submit" id="photo-submit">Submit</button>
</div>
</template>

<script>
import Dropzone from 'dropzone'
Vue.use(Dropzone);
Dropzone.autoDiscover = false
export default {
	data() {
		return {
			url: window.Closet.url + '/collection/upload/' + this.colId,
			image: null,
		}
	},
	props: {
		colId: null,
	},

    methods: {
    	initDropzone: function() {
          		self = this;
		
          		self.$nextTick(function() {
          		self.image = new Dropzone("#image" {
		  			url: self.url,                        
		  			autoProcessQueue: false,
		  			uploadMultiple: true,
		    		parallelUploads: 10,
		    		maxFiles: 10,
		    		maxFilesize: 2,
		    		acceptedFiles: 'image/*',
		    		addRemoveLinks: true,
		    		paramName: "image",
		    		headers: {'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,},
		    				init: function() {
 							this.on('addedfile', function(file) {
  								if (this.files.length > 10) {
   									this.removeFile(this.files[0]);
  								}
 								});
					},
					queuecomplete: function() {
        				toastr.success("Success.");
    						},
    				success: function() {
    					this.removeFile(this.files[0]);
    				}
				}); 
      		});
    	},
    },
    created() {
    	this.initDropzone();
    }
}
</script>