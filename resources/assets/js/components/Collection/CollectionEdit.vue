<template>
<div class="padding-30-bot-15" id="full-line">
  <vue-progress-bar></vue-progress-bar>

  <form v-on:submit.prevent="edit" method="post" enctype="multipart/form-data" class="flex full-width flex-start-res">

    <div class="half-width-res flex flex-start-res">
      <div class="margin-20-bottom">
        <div class="image-file-input margin-center">
          <span class="icon-images"></span>
          <img :src="image_filename">
        </div>
      </div>

      <div class="padding-30-horizontal half-width-res">
        <label class="file-input full-width shadow-1 margin-20-bottom">
          <input id="image-input" @change="previewThumbnail" type="file" :name="image_filename" accept="image/*">
          {{$trans.translation.choose_file}}&nbsp;+
        </label>
        <button class="file-input full-width shadow-1" v-if="image_filename !== null" @click.prevent="removeFile">{{$trans.translation.remove}}</button>
      </div>
    </div>

    <div class="half-width-res padding-15-top">
      <div class="form-group">
        <label class="full-label input-label" for="name">{{$trans.translation.name}}</label>
        <input v-validate="'required|min:3|max:50'" class="form-input" :class="{'is-error': errors.has('name')}" type="text" v-model="name" name="name">
        <span v-show="errors.has('name')" class="span-error">{{ errors.first('name') }}</span>
      </div>
      <div class="form-group">
        <label class="full-label input-label" for="description">{{$trans.translation.description}}</label>
        <input class="form-input" type="text" v-model="description" name="description">
      </div>
      <div class="form-group">
        <label class="full-label input-label" for="visibility">{{$trans.translation.visibility}}</label>
        <select required class="select-input" v-model="visibility" selected="colVisibility">
					<option value="public">{{$trans.translation.public}}</option>
					<option value="private">{{$trans.translation.private}}</option>
				</select>
      </div>
			<div class="align-right padding-15-top">
				<button class="orange-btn normal-sq" type="submit">{{$trans.translation.edit_submit}}</button>
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
      visibility: this.colVisibility,
    }
  },
  props: [
    'colName',
    'colSlug',
    'colDescription',
    'colVisibility',
    'imageSrc',
  ],
  methods: {
    edit() {
      if (document.getElementById("image-input").files.length == 0) {
        this.$Progress.start();
        toastr.info(this.$trans.translation.wait);
        this.$http.put(this.$root.url + '/collection/' + this.colSlug + '/edit', {
          name: this.name,
          description: this.description,
          visibility: this.visibility,
        }).then((response) => {
          this.$Progress.finish();
          toastr.success(this.$trans.translation.success);
        }, (response) => {
          toastr.error(this.$trans.translation.error);
          this.$Progress.fail();
        });
      }
      if (document.getElementById("image-input").files.length > 0) {
        this.$Progress.start();
        toastr.info(this.$trans.translation.wait);
        this.$http.put(this.$root.url + '/collection/' + this.colSlug + '/edit', {
          name: this.name,
          description: this.description,
          visibility: this.visibility,
          thumbnail: this.image_filename,
        }).then((response) => {
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
