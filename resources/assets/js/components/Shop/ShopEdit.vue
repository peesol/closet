<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <div class="panel-body">
    <thumbnail></thumbnail>
    <cover></cover>
    <form v-on:submit.prevent="edit" method="post" class="padding-15-top" id="full-line">
      <label class="full-label heading">{{$trans.translation.public_info}}</label>
        <div class="form-group">
          <label class="full-label input-label">{{$trans.translation.shop_name}}</label>
          <input v-validate="'required|min:3|max:50|alpha_dash'" type="text" :class="{'form-input': true,'is-error': errors.has('name')}" name="name" v-model="name">
          <span v-show="errors.has('name')" class="span-error">{{ errors.first('name') }}</span>
        </div>
        <div class="form-group">
          <label class="full-label input-label" for="URL">{{$trans.translation.shop_url}}</label>
          <div class="input-group" style="margin-bottom:8px;">
            <span class="input-addon left">{{ $root.url }}/</span>
            <input type="text" v-validate="'required|alpha_dash|min:3|max:30'" class="input-addon-field right" :class="{'is-error': errors.has('URL')}" v-model="slug" name="URL">
          </div>
          <span v-show="errors.has('URL')" class="span-error">{{ errors.first('URL') }}</span>
        </div>

      <div class="form-group">
        <label class="full-label input-label" for="decription">{{$trans.translation.description}}</label>
        <textarea v-validate="'max:1000'" class="description-input" name="description" v-model="description"></textarea>
        <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
      </div>
      <div class="align-right padding-15-vertical">
        <button :disabled="$root.loading" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
      </div>
    </form>
    <shop-user-edit></shop-user-edit>
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
      slug: this.shopSlug,
      description: this.shopDescription
    }
  },
  components: {
    cover: Cover,
    thumbnail: Thumbnail,
  },
  props: {
    shopName: null,
    shopCover: null,
    shopDescription: null,
    shopThumbnail: null,
    shopSlug: null,
    userAddress: null,
    userPhone: null,
  },

  methods: {
    edit() {
      this.$Progress.start()
      this.$root.loading = true
      toastr.info(this.$trans.translation.wait)
      this.$http.put(this.$root.url + '/' + this.shopSlug + '/edit/public_info', {
        name: this.name,
        slug: this.slug,
        description: this.description,
      }).then(response => {
        this.$Progress.finish()
        toastr.success(this.$trans.translation.success)
        this.loading = false
        document.location.href = this.$root.url + '/' + this.slug + '/edit/general'
      }, response => {
        toastr.error(this.$trans.translation.error)
        this.$Progress.fail()
        this.$root.loading = false
      });
    },
  },
}
</script>
