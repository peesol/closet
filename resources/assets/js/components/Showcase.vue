<template>
<div class="panel-body">
  <vue-progress-bar></vue-progress-bar>
  <button class="orange-btn normal-sq width-120" @click.prevent="toggled = !toggled">{{$trans.translation.add}}</button>
  <transition name="slide-down-height">
    <div v-show="toggled" class="padding-15-vertical">
      <div class="panel-body shadow-2">
        <form v-on:submit.prevent="create">
          <div class="form-group">
            <label class="full-label heading" for="name">{{$trans.translation.name}}</label>
            <input required class="form-input" type="text" v-model="name" name="name">
          </div>
          <div class="align-right">
            <button class="orange-btn normal-sq" type="submit">{{$trans.translation.create}}</button>
          </div>
        </form>
      </div>
    </div>
  </transition>
  <div class="margin-10-top">

    <div class="alert-box info margin-20-top" v-show="showcases.length">
      <span class="icon-notification"></span>&nbsp;{{$trans.translation.showcase_drag}}
    </div>

    <div class="align-right padding-15-vertical" v-show="showcases.length">
      <button class="orange-btn normal-sq width-120" @click.prevent="save()">{{$trans.translation.edit_submit}}</button>
    </div>
    <draggable :list="showcases" :options="{animation: 200, handle: '.showcase-handle', forceFallback: true }" @change="order">

      <div class="shadow-2 margin-20-bottom" v-for="(showcase, index) in showcases" v-show="showcases.length">
        <div class="color-heading grey-bg">
          <label class="full-label input-label">{{showcase.name}}</label>

        </div>
        <div class="margin-10-top padding-15-bottom padding-15-horizontal">
          <div class="form-group">
            <label class="input-label">{{$trans.translation.show_cover}}</label>
            <button class="transparent-bg" @click.prevent="showToggle(showcase.id, index)">
              <span :class="{ 'icon-checked font-green': showcase.show == true, 'icon-unchecked font-link': showcase.show == false}"></span>
            </button>
          </div>
          <div class="align-right margin-10-top">
            <button class="add-btn round-btn showcase-handle">{{showcase.order}}</button>
            <button @click.prevent="edit(showcase.id)" class="edit-btn round-btn"><i class="icon-cog"></i></button>
            <button @click.prevent="remove(showcase.id, index)" class="delete-btn round-btn"><i class="icon-bin"></i></button>
          </div>
        </div>

      </div>
    </draggable>

    <div v-show="!showcases.length" class="padding-15-vertical">
      <label class="full-label input-label">{{$trans.translation.no_showcase}}</label>
    </div>

  </div>
</div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
  data() {
    return {
      name: null,
      products: null,
      showcases: [],
      toggled: false,
    }
  },
  components: {
    draggable,
  },

  methods: {
    getShowcase() {
      this.$Progress.start()
      this.$http.get(this.$root.url + '/' + this.$route.params.shop + '/edit/showcase/get').then((response) => {
        this.showcases = response.body;
        this.$Progress.finish()
      });
    },
    create(index) {
      this.$Progress.start()
      this.$http.post(this.$root.url + '/' + this.$route.params.shop + ' /edit/showcase/create', {
        name: this.name,
        order: this.showcases.length ? this.showcases.length + 1 : 1
      }).then((response) => {
        this.name = null;
        this.showcases.push(response.body)
        toastr.success(this.$trans.translation.showcase_created);
        this.$Progress.finish()
      }, (response) => {
        this.$Progress.fail()
        toastr.error(this.$trans.translation.error);
      });
    },

    remove(showcaseId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url + '/' + this.$route.params.shop + '/edit/showcase/' + showcaseId + '/delete').then(() => {
        this.showcases.splice(index, 1)
        toastr.success(this.$trans.translation.success)
      });
    },

    edit(showcaseId) {
      document.location.href = this.$root.url + '/' + this.$route.params.shop + '/edit/showcase/' + showcaseId + '/edit';
    },

    showToggle(showcaseId, index) {
      this.$http.put(this.$root.url + '/' + this.$route.params.shop + '/edit/showcase/' + showcaseId + '/toggle_show').then((response) => {
        toastr.success(this.$trans.translation.saved);
        if (this.showcases[index].show) {
          this.$set(this.showcases[index], 'show', false)
        } else {
          this.$set(this.showcases[index], 'show', true)
        }
      }, (response) => {
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
      this.$http.put(this.$root.url + '/' + this.$route.params.shop + '/edit/showcase/order/update', {
        showcases: this.showcases
      }).then((response) => {
        this.$Progress.finish()
        toastr.success(this.$trans.translation.saved);
      }, (response) => {
        this.$Progress.fail()
        toastr.error(this.$trans.translation.error);
      });
    }

  },

  created() {
    this.getShowcase()
  }

}
</script>
