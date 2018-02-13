<template>
<div>
<vue-progress-bar></vue-progress-bar>

                <div style="padding: 0px 20px 30px;">
                <li class="red-font font-bold" style="margin: 15px 0px;">{{$trans.translation.fill_every}}</li>
                <li style="margin: 15px 0px;">{{$trans.translation.product_photo_limit}}</li>
                <li style="margin: 15px 0px;">{{$trans.translation.product_photo_notice}}</li>
                    <form v-on:submit.prevent="submit" method="post">
                      <div class="dropzone" id="image"><div class="dz-message" data-dz-message><span>{{$trans.translation.upload_photo_guide}}</span></div></div>
                      <div style="width:100%; height:20px;"></div>
                    <div>
                        <div class="form-group">
                            <label class="full-label" for="name">{{$trans.translation.product_name}}</label>
                            <input v-validate="'required|min:6'" type="text" class="col-edit-input" name="product_name" v-model="name">
                            <span v-show="errors.has('product_name')" class="span-error">{{ errors.first('product_name') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="full-label" for="price">{{$trans.translation.price}}</label>
                            <input v-validate="'required|numeric|max_value:10000000'" type="text" class="col-edit-input" name="price" v-model="price">
                            <span v-show="errors.has('price')" class="span-error">{{ errors.first('price') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="full-label" for="category">{{$trans.translation.category}}</label>
                            <select required class="select-input" v-model="category" @change="getSubcategory(category)">
                                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                            </select>
                        </div>
                        <transition name="slide-down-input">
                        <div v-show="subcategories.length" class="form-group">
                            <label class="full-label" for="subcategory">{{$trans.translation.subcategory}}</label>
                            <select required class="select-input" v-model.lazy="subcategory" @change="getType(subcategory)">
                                <option v-for="subcategory in subcategories" :value="subcategory.subcategory_id || subcategory.id">{{subcategory.name}}</option>
                            </select>
                        </div>
                        </transition>
                        <transition name="slide-down-input">
                        <div v-show="showElement" class="form-group ">
                            <label class="full-label" for="type">{{$trans.translation.type}}</label>
                            <select v-bind:required="showElement" class="select-input" v-model="type">
                                <option v-for="type in types" :selected="type.name" :value="type.type_id || type.id">{{type.name}}</option>
                            </select>
                        </div>
                        </transition>
                    </div>
                         <div class="form-group">
                            <label class="full-label" for="decription">{{$trans.translation.description}}</label>
                            <textarea v-validate="'required'" class="description-input" name="description" v-model="description">
                            </textarea>
                            <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="full-label" for="visibility">{{$trans.translation.visibility}}</label>
                            <select required class="select-input" :name="visibility" v-model="visibility">
                              <option value="public">{{$trans.translation.public}}</option>
                              <option value="unlisted">{{$trans.translation.unlisted}}</option>
                            </select>
                        </div>

                        <div style="position: relative; text-align: right;">
                            <button id="submit-all" class="col-photo-submit" style="margin-top:0;">{{$trans.translation.sell_submit}}</button>
                        </div>
                        </form>
                    </div>
                </div>
</div>
</template>

<script>
import Dropzone from 'dropzone'
Dropzone.autoDiscover = false
export default {
	data() {
		return {
            categories: [],
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
  computed: {
    showElement: function () {
      if (this.types.length) {
        return true
      } else {
        return false
      }
    },
  },
    methods: {
      getCategory() {
          this.$http.get(this.$root.url + '/category_ajax/get_category' ).then((response)=> {
            this.categories = response.body;
          });
      },
      getSubcategory(category) {
        if (this.category !== null) {
          return this.$http.get(this.$root.url + '/category_ajax/get_subcategory/' + category ).then((response)=> {
            this.subcategory = null;
            this.subcategories = response.body;
            this.type = null;
            this.types = [];
          });
        }
      },
      getType(subcategory) {
        if (this.subcategory !== null && this.subcategory !== undefined) {
          this.$http.get(this.$root.url + '/category_ajax/get_type/' + subcategory ).then((response)=> {
            this.types = response.body;
            this.type = null;
          });
        }
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
              dictRemoveFile: '&times;',
              dictCancelUpload: '&times;',
              headers: {'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,},
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
                  formData.append("category_id", self.category);
                  formData.append("subcategory_id", self.subcategory);
                  formData.append("type_id", self.type);
                },
                processing: function() {
                  self.$Progress.start();
                },
                success: function() {
                  toastr.success(self.$trans.translation.success, toastr.options = {"preventDuplicates": true,});
                  this.removeFile(this.files[0]);
                  self.$Progress.finish();
                  document.location.href= self.$root.url + '/sell/new';
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
        this.getCategory();
        this.initDropzone();
    },
}
</script>
