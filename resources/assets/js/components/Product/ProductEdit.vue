<template>
<div style="padding: 0 30px 45px 30px;">
<vue-progress-bar></vue-progress-bar>
        <form v-on:submit.prevent="edit" method="post" enctype="multipart/form-data" class="flex">
            <div class="add-col-panel flex" style="padding: 40px 15px;">
                <h4 class="full-label no-margin" style="position:absolute; top:10px; left:0;">{{$trans.translation.thumbnail}}</h4>
                <div class="image-input">
                <span class="icon-images"></span>
                <img class="image-input-img" :src="image_filename">
                </div>
                <ul style="list-style-type: none; padding: 0; margin: 0;">
                <li><div class="image-file-input">
                <input id="image-input" class="image-input-input" @change="previewThumbnail" type="file" :name="image_filename" accept="image/*">
                <p style="padding:12px; text-align:center;">{{$trans.translation.choose_file}}</p>
                </div></li>
                <li><button class="image-file-input" v-if="image_filename !== null" @click.prevent="removeFile">{{$trans.translation.remove}}</button></li>
                </ul>
            </div>
        <div class="col-edit-panel">
            <div class="form-group col-flex" id="full-label">
                <label class="full-label" for="name">{{$trans.translation.product_name}}</label>
                <input v-validate="'required|min:6'" :class="{'col-edit-input': true,'is-error': errors.has('product_name')}" type="text" v-model="name" name="product_name">
                <span v-show="errors.has('product_name')" class="span-error">{{ errors.first('product_name') }}</span>
            </div>
            <div class="form-group col-flex" id="full-label">
                <label class="full-label" for="price">{{$trans.translation.price}}</label>
                <input v-validate="'required|numeric'" class="col-edit-input" type="text" v-model="price" name="price">
                <span v-show="errors.has('price')" class="span-error">{{ errors.first('price') }}</span>
            </div>
            <div class="form-group col-flex" id="full-label">
                <label class="full-label" for="visibility">{{$trans.translation.visibility}}</label>
                <select required class="select-input" :name="visibility" v-model="visibility" @change="getSubCategory(category)">
                  <option value="public">{{$trans.translation.public}}</option>
                  <option value="unlisted">{{$trans.translation.unlisted}}</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="full-label" style="position:relative;">
            <label class="full-label" for="description">{{$trans.translation.description}}</label>
            <textarea v-validate="'required'" class="description-input margin-bot-10px" type="text" v-model="description" name="description"></textarea>
            <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
            <button class="col-submit" type="submit" style="right:0;">{{$trans.translation.edit_submit}}</button>
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
			url: window.Closet.url,
      trans: this.$trans,
		}
	},
	props: {
		productSlug: null,
		productName: null,
		productPrice:null,
		productDescription:null,
		productVisibility:null,
    imageSrc: null,
	},

    methods: {
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
            edit() {
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 2000;
                if(document.getElementById("image-input").files.length == 0) {
                    this.$Progress.start();
                    toastr.info(this.$trans.translation.wait);
                    this.$http.put(this.url + '/product/' + this.productSlug + '/edit', {
                    name: this.name,
                    description: this.description,
                    price: this.price,
                    visibility: this.visibility,
                    }).then((response)=> {
                        this.$Progress.finish();
                        toastr.success(this.$trans.translation.success);
                    }, (response) => {
                        toastr.error(this.$trans.translation.error);
                        this.$Progress.fail();
                    });
                } else if (document.getElementById("image-input").files.length > 0) {
                    this.$Progress.start();
                    toastr.info(this.$trans.translation.wait);
                this.$http.put(this.url + '/product/' + this.productSlug + '/edit', {
                    name: this.name,
                    description: this.description,
                    price: this.price,
                    thumbnail: this.image_filename,
                    visibility: this.visibility,
                    }).then((response)=> {
                        this.$Progress.finish();
                        toastr.success(this.$trans.translation.success);
                    }, (response) => {
                        toastr.error(this.$trans.translation.error);
                        this.$Progress.fail();
                    });
                }
            }
    },
    created() {
    }
}
</script>
