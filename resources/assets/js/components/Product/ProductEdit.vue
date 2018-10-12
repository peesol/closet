<template>
<div class="padding-30-bot-15" id="full-line">
  <vue-progress-bar></vue-progress-bar>
  <form v-on:submit.prevent="edit" enctype="multipart/form-data" class=" full-width">
    <div class="flex flex-start-res">

      <div class="half-width-res flex flex-start-res">
        <div class="margin-20-bottom">
          <div class="image-file-input margin-center">
            <span class="fas fa-images"></span>
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
          <label class="full-label input-label" for="name">{{$trans.translation.product_name}}</label>
          <input v-validate="'required|min:6'" class="form-input" :class="{'is-error': errors.has('product_name')}" type="text" v-model="name" name="product_name">
          <span v-show="errors.has('product_name')" class="span-error">{{ errors.first('product_name') }}</span>
        </div>
        <div class="form-group">
          <label class="full-label input-label" for="price">{{$trans.translation.price}}</label>
          <input v-validate="'required|numeric'" class="form-input" type="text" v-model="price" name="price">
          <span v-show="errors.has('price')" class="span-error">{{ errors.first('price') }}</span>
        </div>
        <div class="form-group">
          <label class="full-label input-label" for="visibility">{{$trans.translation.visibility}}</label>
          <select required class="select-input" :name="visibility" v-model="visibility" @change="getSubCategory(category)">
            <option value="public">{{$trans.translation.public}}</option>
            <option value="unlisted">{{$trans.translation.unlisted}}</option>
          </select>
        </div>
      </div>

    </div>

    <div class="full-width padding-15-top">
      <div class="form-group">
        <label class="full-label input-label" for="description">{{$trans.translation.description}}</label>
        <textarea v-validate="'required'" class="description-input" type="text" v-model="description" name="description"></textarea>
        <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
      </div>
      <div class="align-right full-width padding-15-top">
        <button :disabled="$root.loading || errors.any()" class="orange-btn normal-sq width-120" type="submit">{{$trans.translation.edit_submit}}</button>
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
      name: this.productName,
      price: this.productPrice,
      description: this.productDescription,
      visibility: this.productVisibility,
      formVisible: false,
    }
  },
  props: {
    productSlug: null,
    productName: null,
    productPrice: null,
    productDescription: null,
    productVisibility: null,
    imageSrc: null,
  },

  methods: {
    previewThumbnail(event) {
      var input = event.target;
      if (input.files && input.files[0]) {
        if (input.files[0].size > 1048576) {
          alert(this.$trans.translation.file_size_limit + ' 1 MB');
          this.removefile()
        }
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
    edit() {
      toastr.options.preventDuplicates = true;
      toastr.options.timeOut = 2000;
      this.$root.loading = true
      if (document.getElementById("image-input").files.length == 0) {
        this.$Progress.start();
        toastr.info(this.$trans.translation.wait);
        this.$http.put(this.$root.url + '/product/' + this.productSlug + '/edit', {
          name: this.name,
          description: this.description,
          price: this.price,
          visibility: this.visibility,
        }).then(response => {
          this.$Progress.finish();
          this.$root.loading = false
          toastr.success(this.$trans.translation.success)
        }, response => {
          this.$Progress.fail();
          this.$root.loading = false
          toastr.error(this.$trans.translation.error);
        });
      } else if (document.getElementById("image-input").files.length > 0) {
        this.$Progress.start();
        toastr.info(this.$trans.translation.wait);
        this.$http.put(this.$root.url + '/product/' + this.productSlug + '/edit', {
          name: this.name,
          description: this.description,
          price: this.price,
          thumbnail: this.image_filename,
          visibility: this.visibility,
        }).then(response => {
          this.$Progress.finish();
          this.$root.loading = false
          toastr.success(this.$trans.translation.success)
        }, response => {
          this.$Progress.fail();
          this.$root.loading = false
          toastr.error(this.$trans.translation.error);
        });
      }
    }
  },
}
</script>
