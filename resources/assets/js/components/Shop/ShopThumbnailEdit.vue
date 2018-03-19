<template>
<div id="full-line">
  <label class="full-label heading padding-15-bottom">
    {{$trans.translation.thumbnail}}
    <span class="font-small">100px*100px</span>
  </label>

  <form v-on:submit.prevent="edit" method="post">
    <div class="flex">
      <div class="profile-thumbnail-input">
        <span class="icon-images"></span>
        <img :src="thumbnail">
      </div>

      <div class="flex-start padding-15-left" style="width:180px">
        <label class="file-input full-width shadow-1 margin-10-bottom">
            <input @change="previewThumbnail" id="thumb-input" type="file" :name="thumbnail" accept="image/*"/>
            {{$trans.translation.choose_file}}&nbsp;+
        </label>
        <button class="file-input full-width shadow-1" v-if="thumbnail !== null" @click.prevent="removeThumbnail">{{$trans.translation.remove}}</button>
      </div>
    </div>

    <div class="padding-15-vertical align-right">
      <button @click.prevent="edit" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
    </div>
  </form>

</div>
</template>

<script>
export default {
  data() {
    return {
      thumbnail: this.$parent.shopThumbnail,
    }
  },
  methods: {
    edit() {
      toastr.options.preventDuplicates = true;
      toastr.options.timeOut = 2000;

      if (document.getElementById("thumb-input").files.length == 0) {
        toastr.info(this.$trans.translation.dropzone_null);
      }

      if (document.getElementById("thumb-input").files.length > 0) {
        this.$Progress.start();
        toastr.info(this.$trans.translation.wait);
        this.$http.put(this.$root.url + '/' + this.$parent.shopSlug + '/edit/thumbnail', {
          thumbnail: this.thumbnail,
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
          vm.thumbnail = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    },
    removeThumbnail() {
      this.thumbnail = null;
    },
  },
}
</script>
