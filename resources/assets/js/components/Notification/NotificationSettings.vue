<template>
<div v-show="!$root.loading">
  <vue-progress-bar></vue-progress-bar>
  <table class="c-table">
    <tr>
      <td>
        <label class="font-15em input-label">{{ $trans.translation.notification_settings.order }}</label><br>
        <small>{{ $trans.translation.notification_settings.order_small }}</small>
      </td>
      <td class="">
        <label class="switch float-right">
          <input @change.prevent="edit()" v-model="options.order" type="checkbox" :checked="options.order">
          <span class="slider"></span>
        </label>
      </td>
    </tr>
    <tr>
      <td>
        <label class="font-15em input-label">{{ $trans.translation.email }}</label><br>
        <small>{{ $trans.translation.notification_settings.email_small }}</small>
      </td>
      <td class="">
        <label class="switch float-right">
          <input @change.prevent="edit()" v-model="options.email" type="checkbox" :checked="options.email">
          <span class="slider"></span>
        </label>
      </td>
    </tr>
    <tr>
      <td>
        <label class="font-15em input-label">{{ $trans.translation.comments }}</label><br>
        <small>{{ $trans.translation.notification_settings.comments_small }}</small>
      </td>
      <td class="">
        <label class="switch float-right">
          <input @change.prevent="edit()" v-model="options.comments" type="checkbox" :checked="options.comments">
          <span class="slider"></span>
        </label>
      </td>
    </tr>
    <tr>
      <td>
        <label class="font-15em input-label">{{ $trans.translation.notification_settings.following }}</label><br>
        <small>{{ $trans.translation.notification_settings.following_small }}</small>
      </td>
      <td class="">
        <label class="switch float-right">
          <input @change.prevent="edit()"  v-model="options.following" type="checkbox" :checked="options.following">
          <span class="slider"></span>
        </label>
      </td>
    </tr>
  </table>

</div>
</template>

<script>
export default {
  data() {
    return {
      options: []
    }
  },
  methods: {
    get() {
      this.$Progress.start()
      this.$root.loading = true
      this.$http.get(this.$root.url + '/settings/notification/get').then(response => {
        this.options = response.body
        this.$root.loading = false
        this.$Progress.finish()
      })
    },
    edit() {
      this.$http.put(this.$root.url + '/settings/notification/update', {
        changes: this.options
      }).then(response => {
        toastr.success(this.$trans.translation.saved)
      }, response => {
        toastr.error(this.$trans.translation.error)
      })
    }
  },
  created() {
    this.get()
  }
}
</script>
