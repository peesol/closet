<template>
<div class="padding-30-bot-15 relative" id="full-line">
  <load-overlay bg="white-bg" :show="!loaded"></load-overlay>
  <div class="thumbnail-grid" v-if="images.length">
    <div v-for="(image, index) in images" class="products-img">
      <img class="object-cover black-bg" :alt="image.filename" :src="image.filename">
      <button v-show="image.id && images.length > 0" @click.prevent="remove(image.id, index)" class="align-top-right flat-btn icon-bg padding-10"><i class="fas fa-trash-alt"></i></button>
    </div>
  </div>
  <div v-else class="padding-15-vertical">
    <label class="full-label input-label">{{$trans.translation.col_photo_none}}</label>
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
            <span>{{$trans.translation.upload_photo_size_limit}} 1.5 MB</span>
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
      dropzoneUrl: this.$root.url + '/collection/' + this.colSlug + '/upload/' + this.colId,
      loaded: false
    }
  },
  props: {
    colSlug: null,
    colId: null
  },
  methods: {
    getPhoto() {
      this.$http.get(this.$root.url + '/collection_api/img/' + this.colSlug).then(response => {
        this.images = response.body.data;
        this.loaded = true
      });
    },
    remove(imageId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
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
          headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
          },
          init: function() {
            this.on('addedfile', function(file) {
              if (this.files.length + self.images.length > 10 || this.files.length > 10) {
                this.removeFile(this.files[0]);
              }
              if (file.size > 1572864) {
                alert(self.$trans.translation.file_size_limit + ' 1.5 MB');
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
              filename: file.dataURL
            })
            toastr.success(self.$trans.translation.success)
            self.$Progress.finish()
            this.removeFile(this.files[0])
          },
          error: function() {
            self.$Progress.fail()
            toastr.error(self.$trans.translation.error)
            this.removeFile(this.files[0])
          },
        });
      });
    },
    submit() {
      self.image.processQueue()
    }
  },
  created() {
    this.getPhoto()
    this.initDropzone()
  }
}
</script>
