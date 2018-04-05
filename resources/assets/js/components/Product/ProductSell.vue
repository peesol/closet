<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <ul class="notice-ul">
    <li class="font-red font-bold">{{$trans.translation.fill_every}}</li>
    <li>{{$trans.translation.product_photo_limit}}</li>
    <li>{{$trans.translation.product_photo_notice}}</li>
  </ul>

  <form v-on:submit.prevent="submit" method="post">
    <div class="dropzone margin-20-bottom" id="image">
      <div class="dz-message" data-dz-message><span>{{$trans.translation.upload_photo_guide}}</span></div>
    </div>
    <div></div>
    <div>
      <div class="form-group">
        <label class="full-label input-label" for="name">{{$trans.translation.product_name}}</label>
        <input v-validate="'required|min:6'" type="text" class="form-input" name="product_name" v-model="name">
        <span v-show="errors.has('product_name')" class="span-error">{{ errors.first('product_name') }}</span>
      </div>
      <div class="form-group">
        <label class="full-label input-label" for="price">{{$trans.translation.price}}</label>
        <input v-validate="'required|numeric|max_value:10000000'" type="text" class="form-input" name="price" v-model="price">
        <span v-show="errors.has('price')" class="span-error">{{ errors.first('price') }}</span>
      </div>
      <div class="form-group margin-10-bottom">
        <label class="full-label input-label" for="category">{{$trans.translation.category}}</label>
        <select required class="select-input" v-model="category" @change.prevent="selectCategory(category)">
          <option v-for="category in categories" :value="category">{{category.name}}</option>
        </select>
      </div>
      <transition name="slide-down-input">
        <div class="form-group margin-10-bottom" v-show="subcategories.length">
          <label class="full-label input-label" for="subcategory">{{$trans.translation.subcategory}}</label>
          <select required class="select-input" v-model="subcategory" @change.prevent="selectSubcategory(subcategory)">
            <option v-for="(subcategory, index) in subcategories" :value="subcategory">{{subcategory.name}}</option>
          </select>
        </div>
      </transition>
      <transition name="slide-down-input">
        <div class="form-group margin-10-bottom" v-show="types.length >= 1">
          <label class="full-label input-label" for="type">{{$trans.translation.type}}</label>
          <select :required="types.length >= 1" class="select-input" v-model="type">
            <option v-for="type in types" :value="type.id">{{type.name}}</option>
          </select>
        </div>
      </transition>
    </div>
    <div class="form-group">
      <label class="full-label input-label" for="decription">{{$trans.translation.description}}</label>
      <textarea v-validate="'required'" class="description-input" name="description" v-model="description"></textarea>
      <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
    </div>

    <div class="form-group">
      <label class="full-label input-label" for="visibility">{{$trans.translation.visibility}}</label>
      <select required class="select-input" :name="visibility" v-model="visibility">
                              <option value="public">{{$trans.translation.public}}</option>
                              <option value="unlisted">{{$trans.translation.unlisted}}</option>
                            </select>
    </div>

    <div class="align-right full-width padding-15-vertical margin-10-top">
      <button type="submit" id="submit-all" class="orange-btn normal-sq width-120">{{$trans.translation.sell_submit}}</button>
    </div>
  </form>

</div>
</div>
</template>

<script>
import Dropzone from 'dropzone'
import {
  categories
} from '../../category/getter'
Dropzone.autoDiscover = false
export default {
  data() {
    return {
      categories: categories({
        locale: this.$root.locale
      }),
      subcategories: [],
      types: [],
      category: null,
      subcategory: null,
      type: null,
      name: null,
      price: null,
      description: null,
      visibility: null,
    }
  },
  methods: {
    selectCategory(category) {
      this.subcategories = category.subcategory
      this.subcategory = []
      this.type = null
      this.types = []
    },
    selectSubcategory(subcategory) {
      this.types = subcategory.type
      this.type = null
    },
    initDropzone: function() {
      self = this;
      self.$nextTick(function() {
        self.image = new Dropzone('#image', {
          method: 'post',
          url: self.$root.url + '/sell/new',
          autoProcessQueue: false,
          uploadMultiple: true,
          parallelUploads: 7,
          maxFiles: 7,
          maxFilesize: 2,
          acceptedFiles: 'image/*',
          addRemoveLinks: true,
          paramName: 'image',
          dictRemoveFile: '×',
          dictCancelUpload: '×',
          headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
          },
          init: function() {
            this.on('addedfile', function(file) {
              if (this.files.length > 7) {
                this.removeFile(this.files[0]);
              }
            });
          },
          sendingmultiple: function(data, xhr, formData) {
            formData.append("name", self.name);
            formData.append("price", self.price);
            formData.append("description", self.description);
            formData.append("visibility", self.visibility);
            formData.append("category_id", self.category.id);
            formData.append("subcategory_id", self.subcategory.id);
            formData.append("type_id", self.type);
          },
          processing: function() {
            self.$Progress.start();
          },
          success: function() {
            toastr.success(self.$trans.translation.success, toastr.options = {
              "preventDuplicates": true,
            });
            this.removeFile(this.files[0]);
            self.$Progress.finish();
            document.location.href = self.$root.url + '/sell/new';
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
    this.initDropzone();
  },
}
</script>
