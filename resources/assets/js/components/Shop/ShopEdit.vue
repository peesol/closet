<template>
<div>
  <vue-progress-bar></vue-progress-bar>
  <thumbnail ref="thumbnail"></thumbnail>
  <cover ref="cover"></cover>
  <div class="panel-body">
    <form @submit.prevent="edit" class="padding-15-top relative" id="full-line">
      <load-overlay bg="white-bg" :show="loading" padding="40px 0"></load-overlay>
      <label class="full-label heading">{{$trans.translation.public_info}}</label>
        <div class="form-group">
          <label class="full-label input-label">{{$trans.translation.shop_name}}</label>
          <input required v-validate="'required|min:3|max:30|alpha_dash'" type="text" :class="{'form-input': true,'is-error': errors.has('name')}" name="name" v-model="name">
          <span v-show="errors.has('name')" class="span-error">{{ errors.first('name') }}</span>
          <span v-show="error.name" v-for="msg in error.name" class="span-error">{{ msg }}</span>
        </div>
        <div class="form-group">
          <label class="full-label input-label" for="URL">{{$trans.translation.shop_url}}</label>
          <div class="input-group" style="margin-bottom:8px;">
            <span class="input-addon left">{{ $root.url }}/</span>
            <input required type="text" v-validate="'required|alpha_dash|min:3|max:30'" class="input-addon-field right" :class="{'is-error': errors.has('URL')}" v-model="slug" name="URL">
          </div>
          <span v-show="errors.has('URL')" class="span-error">{{ errors.first('URL') }}</span>
          <span v-show="error.slug" v-for="msg in error.slug" class="span-error">{{ msg }}</span>
        </div>

      <div class="form-group">
        <label class="full-label input-label" for="decription">{{$trans.translation.description}}</label>
        <textarea v-validate="'max:1000'" class="description-input" name="description" v-model="description"></textarea>
        <span v-show="errors.has('description')" class="span-error">{{ errors.first('description') }}</span>
      </div>
      <div class="align-right padding-15-vertical">
        <button type="submit" :disabled="$root.loading || errors.any()" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
      </div>
    </form>
  </div>
  <shop-user-edit ref="private"></shop-user-edit>
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
      name: null,
      slug: null,
      description: null,
      cover: null,
      thumbnail: null,
      address: null,
      phone: null,
      loading: false,
      error: []
    }
  },
  components: {
    cover: Cover,
    thumbnail: Thumbnail,
  },

  methods: {
    get() {
      this.$root.loading = true
      this.$http.get(this.$root.url + '/settings/get_user').then(response => {
        this.name = response.body.name
        this.slug = response.body.slug
        this.description = response.body.description
        this.$refs.cover.cover = response.body.cover
        this.$refs.thumbnail.thumbnail = response.body.thumbnail
        this.$refs.private.phone = response.body.phone
        this.$refs.private.address = response.body.address
        this.$root.loading = false
      })
    },
    edit() {
      this.$Progress.start()
      this.loading = true
      toastr.info(this.$trans.translation.wait)
      this.$http.put(this.$root.url + '/settings/public_info', {
        name: this.name,
        slug: this.slug,
        description: this.description,
      }).then(response => {
        this.$Progress.finish()
        toastr.success(this.$trans.translation.success)
        this.loading = false
        this.error = []
      }, response => {
        toastr.error(this.$trans.translation.error)
        console.log(response.body);
        this.error = response.body.errors
        this.$Progress.fail()
        this.loading = false
      });
    },
  },
  created() {
    this.get()
  }
}
</script>
