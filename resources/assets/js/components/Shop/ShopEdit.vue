<template>
<div>
<vue-progress-bar></vue-progress-bar>
                    <div style="padding: 0px 20px;">
                      <thumbnail :shop-thumbnail="shopThumbnail"></thumbnail>
                      <cover :shop-cover="shopCover"></cover>
                        <form v-on:submit.prevent="edit" method="post">
                        <div style="padding:0;">
                            <div class="form-group">
                                <label class="form-label" for="name">{{$trans.translation.shop_name}}</label>
                                <input v-validate="'required|min:3|max:50|alpha_dash'" type="text" :class="{'form-input': true,'is-error': errors.has('name')}" name="name" v-model="name">
                                <span v-show="errors.has('name')" class="span-error">{{ errors.first('name') }}</span>
                            </div>
                            <div class="form-group">
                                 <label class="form-label" for="URL">{{$trans.translation.shop_url}}</label>
                                 <div class="input-group" style="margin-bottom:8px;">
                                     <span class="input-addon">{{ url }}/</span>
                                     <input type="text" v-validate="'required|alpha_dash|min:3|max:30'" :class="{'input-addon-field': true,'is-error': errors.has('URL')}" v-model="slug" name="URL">
                                 </div>
                                 <span v-show="errors.has('URL')" class="span-error">{{ errors.first('URL') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="decription">{{$trans.translation.description}}</label>
                            <textarea v-validate="'max:1000'" class="description-input" name="description" v-model="description">
                            </textarea>
                            <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
                        </div>
                        <div style="position: relative; text-align: right;">
                            <button id="submit-all" class="col-photo-submit" style="margin-top:0;">{{$trans.translation.edit_submit}}</button>
                        </div>
                        </form>
                        <div id="full-line" style="margin-top: 20px;"></div>
                        <shop-user-edit :user-address="userAddress" :user-phone="userPhone"></shop-user-edit>
                    </div>
                </div>
</div>
</template>

<script>
import Cover from './ShopCoverEdit.vue'
import Thumbnail from './ShopThumbnailEdit.vue'
import Info from './ShopUserEdit.vue'
export default {
	data() {
		return {
			name: this.shopName,
			slug: this.$root.shopSlug,
			description: this.shopDescription,
			url: window.Closet.url,
      trans: this.$trans,
		}
	},
  components: {
    cover: Cover,
    thumbnail: Thumbnail,
  },
	props: {
      shopName: null,
      shopCover: null,
      shopDescription:null,
      shopThumbnail:null,
      userAddress:null,
      userPhone:null,
	},

    methods: {
            edit() {
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 2000;
                    this.$Progress.start();
                    toastr.info(this.$trans.translation.wait);
                    this.$http.put(this.url + '/' + this.$root.shopSlug + '/edit', {
                    name: this.name,
                    slug: this.slug,
                    description: this.description,
                    }).then((response)=> {
                        this.$Progress.finish();
                        toastr.success(this.$trans.translation.success);
                        document.location.href= this.url + '/' + this.slug + '/edit';
                    }, (response) => {
                        toastr.error(this.$trans.translation.error);
                        this.$Progress.fail();
                    });
            },
    },
    created() {

    }
}
</script>
