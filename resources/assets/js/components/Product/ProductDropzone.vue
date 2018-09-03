<template>
<div class="padding-30-bot-15" id="full-line">

  <div v-show="images.length" class="padding-15-vertical thumbnail-grid">
    <div v-for="(image, index) in images" class="products-img">
      <img class="products-img-thumb" alt="currently uploading..." :src="image.filename">
      <button v-show="image.id && images.length > 1" @click.prevent="remove(image.id, index)" class="align-top-right round-btn red-bg"><span class="icon-bin"></span></button>
    </div>
  </div>

  <div class="padding-15-vertical">
    <button class="orange-btn normal-sq" @click.prevent="formVisible = !formVisible">
					{{$trans.translation.upload_photo}}&nbsp;&nbsp;+
			</button>
  </div>

  <transition name="slide-down-height">
    <div v-show="formVisible" class="panel-body border-radius-5 grey-bg">
      <div class="dropzone" id="image">
        <div class="dz-message" data-dz-message>
          <span>{{$trans.translation.upload_photo_guide}}</span><br>
          <span>{{$trans.translation.upload_photo_size_limit}} 2 MB</span>
        </div>
      </div>
      <div class="align-right padding-15-top">
        <button class="orange-btn normal-sq" @click.prevent="submit" id="photo-submit">{{$trans.translation.upload_submit}}</button>
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
      dropzoneUrl: this.$root.url + '/product/' + this.productSlug + '/upload_photo',
    }
  },
  props: {
    productSlug: null,
    productId: null,
  },

  methods: {
    getPhoto() {
      this.$http.get(this.$root.url + '/product/' + this.productSlug + '/get_photo')
        .then((response) => {
          return response.json()
            .then((json) => {
              this.images = json.data;
            });
        });
    },

    remove(imageId, index) {
      if (!confirm(this.$trans.translation.photo_delete_confirm)) {
        return;
      }
      this.$Progress.start();
      this.$http.delete(this.$root.url + '/product/delete_photo/' + imageId).then(() => {
        this.images.splice(index, 1)
        this.$Progress.finish()
        toastr.success(this.$trans.translation.success)
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
          headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
          },
          init: function() {
            this.on('addedfile', function(file) {
              if (this.files.length + self.images.length > 7 || this.files.length > 7) {
                this.removeFile(this.files[0])
              }
              if (file.size > 2097152) {
                alert(self.$trans.translation.file_size_limit + ' 2 MB');
                this.removeFile(file)
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
            toastr.success(self.$trans.translation.success, toastr.options = {
              "preventDuplicates": true,
            })
            this.removeFile(this.files[0])
            self.$Progress.finish()
          },
          error: function() {
            self.$Progress.fail();
            toastr.error(self.$trans.translation.error, toastr.options = {
              "preventDuplicates": true,
            });
            this.removeFile(this.files[0]);
          },

        });
      });
    },
    submit() {
      self.image.processQueue();
    }
  },
  created() {
    this.getPhoto();
    this.initDropzone();
  }
}
</script>
