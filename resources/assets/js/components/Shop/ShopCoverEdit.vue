<template>
<div style="padding: 0 0 20px 0px;">
  <label class="full-label">{{$trans.translation.cover}}&nbsp;1100*315</label>
  <form v-on:submit.prevent="edit" method="post">
    <div class="flex">
        <div class="shop-thumb-input margin-top-10px">
          <span class="icon-images"></span>
          <img :src="cover">
        </div>
        <ul style="list-style-type: none; padding: 0; margin: 0;">
          <li>
            <div class="image-file-input">
              <input id="cover-input" class="image-input-input" @change="previewCover" type="file" :name="cover" accept="image/*">
              <p style="padding:12px; text-align:center;">{{$trans.translation.choose_file}}</p>
            </div>
          </li>
          <li><button class="image-file-input" v-if="cover !== null" @click.prevent="removeCover">{{$trans.translation.remove}}</button></li>
        </ul>
    </div>
  <div style="position: relative; text-align: right;">
      <button @click.prevent="edit" id="submit-all" class="col-photo-submit" style="margin-top:0;">{{$trans.translation.edit_submit}}</button>
  </div>
  </form>
  <div id="full-line" style="margin-top: 20px;"></div>
</div>
</template>

<script>
export default {
	data() {
		return {
      cover: this.shopCover,
			url: window.Closet.url,
		}
	},
	props: {
    shopCover:null,
	},

    methods: {
            edit() {
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 2000;

                if(document.getElementById("cover-input").files.length == 0) {
                    toastr.info(this.$trans.translation.dropzone_null);
                }

                if(document.getElementById("cover-input").files.length > 0){
                    this.$Progress.start();
                    toastr.info(this.$trans.translation.wait);
                this.$http.put(this.$root.url + '/' + this.$root.shopSlug + '/edit/cover', {
                    cover: this.cover,
                    }).then((response)=> {
                        this.$Progress.finish();
                        toastr.success(this.$trans.translation.success);
                    }, (response) => {
                        toastr.error(this.$trans.translation.error);
                        this.$Progress.fail();
                    });
                }
            },
            previewCover(event) {
                var input = event.target;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        var vm = this;
                    reader.onload = function(e) {
                        vm.cover = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            },
            removeCover() {
                this.cover = null;
            },
    },
    created() {

    }
}
</script>
