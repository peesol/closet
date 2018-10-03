<template>
<div class="panel-body">
  <vue-progress-bar></vue-progress-bar>
  <button class="orange-btn normal-sq width-120" @click.prevent="toggled = !toggled">{{$trans.translation.add}}</button>
  <button :disabled="$root.loading" v-show="showcases.length" class="orange-btn normal-sq width-120 float-right" @click.prevent="save()">{{$trans.translation.showcase_order_save}}</button>
  <transition name="slide-down-height">
    <div v-show="toggled" class="padding-15-vertical">
      <div class="panel-body shadow-2">
        <form v-on:submit.prevent="create">
          <div class="form-group">
            <label class="full-label heading" for="name">{{$trans.translation.name}}</label>
            <input required class="form-input" type="text" v-model="name" name="name">
          </div>
          <div class="align-right">
            <button :disabled="$root.loading" class="orange-btn normal-sq" type="submit">{{$trans.translation.create}}</button>
          </div>
        </form>
      </div>
    </div>
  </transition>
  <div class="margin-30-top">
      <div class="shadow-2 margin-20-bottom" v-for="(showcase, index) in showcases" v-show="showcases.length">
        <div class="color-heading grey-bg">
          <label class="full-label input-label">{{showcase.name}}</label>
        </div>
        <div>
          <div id="full-line" class="padding-10">
            <label class="input-label margin-10-right">{{$trans.translation.show_cover}}</label>
            <label class="switch near-text">
              <input @change.prevent="showToggle(showcase.id, index)" type="checkbox" :checked="showcase.show">
              <span class="slider"></span>
            </label>
          </div>
          <div class="align-right padding-10">
            <div class="input-group lh-35 float-left">
              <button :disabled="index === showcases.length - 1" class="flat-btn fas fa-chevron-circle-down" v-show="true" @click.prevent="setArrayDown(index, showcase.order)"></button>
              <span class="padding-15-horizontal arial font-large">{{ index + 1 }}</span>
              <button :disabled="index === 0" class="flat-btn fas fa-chevron-circle-up" v-show="true" @click.prevent="setArrayUp(index, showcase.order)"></button>
            </div>
            <button @click.prevent="edit(showcase.id)" class="flat-btn"><i class="fas fa-pen"></i></button>
            <button @click.prevent="remove(showcase.id, index)" class="flat-btn delete"><i class="fas fa-trash-alt"></i></button>
          </div>
        </div>
      </div>

    <div v-show="!showcases.length" class="padding-15-vertical align-center">
      <h2 class="font-grey">{{$trans.translation.no_showcase}}</h2>
    </div>

  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      name: null,
      products: null,
      showcases: [],
      toggled: false,
    }
  },

  methods: {
    setArrayDown(index, order) {
      let array = [this.showcases[index], this.showcases[index + 1]];
      this.showcases.splice(index, 2, array[1], array[0] );
    },
    setArrayUp(index, order) {
      let array = [this.showcases[index], this.showcases[index + 1], this.showcases[index - 1]];
      if (index < this.showcases.length - 1) {
        this.showcases.splice(index - 1, 3, array[0], array[2], array[1] );
      } else if (index === this.showcases.length - 1 && this.showcases.length !== 2) {
        this.showcases.splice(index - 1, this.showcases.length - 1, array[0], array[2] );
      } else if (this.showcases.length === 2) {
        this.showcases.splice(index - 1, this.showcases.length, array[0], array[2] );
      }
    },
    getShowcase() {
      this.$Progress.start()
      this.$root.loading = true
      this.$http.get(this.$root.url +'/manage/showcase/get').then(response => {
        this.showcases = response.body;
        this.$Progress.finish()
        this.$root.loading = false
      });
    },
    create(index) {
      this.$Progress.start()
      this.$root.loading = true
      toastr.info(this.$trans.translation.wait);
      this.$http.post(this.$root.url +'/manage/showcase/create', {
        name: this.name,
        order: this.showcases.length ? this.showcases.length + 1 : 1
      }).then(response => {
        this.name = null;
        this.showcases.push(response.body)
        this.$Progress.finish()
        this.$root.loading = false
        toastr.success(this.$trans.translation.showcase_created);
      }, response => {
        this.$Progress.fail()
        this.$root.loading = false
        toastr.error(this.$trans.translation.error);
      });
    },

    remove(showcaseId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url +'/manage/showcase/' + showcaseId + '/delete').then(response => {
        this.showcases.splice(index, 1)
        toastr.success(this.$trans.translation.success)
      });
    },

    edit(showcaseId) {
      document.location.href = this.$root.url +'/manage/showcase/' + showcaseId + '/edit';
    },

    showToggle(showcaseId, index) {
      this.$http.put(this.$root.url +'/manage/showcase/' + showcaseId + '/toggle_show').then(response => {
        toastr.success(this.$trans.translation.saved);
        if (this.showcases[index].show) {
          this.$set(this.showcases[index], 'show', false)
        } else {
          this.$set(this.showcases[index], 'show', true)
        }
      }, response => {
        toastr.error(this.$trans.translation.error);
      });
    },
    order() {
      this.showcases.map((showcase, index) => {
        showcase.order = index + 1;
      })
    },
    save() {
      this.$Progress.start()
      this.$root.loading = true
      toastr.info(this.$trans.translation.wait);
      this.$http.put(this.$root.url +'/manage/showcase/order/update', {
        showcases: this.showcases
      }).then(response => {
        this.$Progress.finish()
        this.$root.loading = false
        toastr.success(this.$trans.translation.saved);
      }, response => {
        this.$Progress.fail()
        this.$root.loading = false
        toastr.error(this.$trans.translation.error);
      });
    }

  },

  created() {
    this.getShowcase()
  }

}
</script>
