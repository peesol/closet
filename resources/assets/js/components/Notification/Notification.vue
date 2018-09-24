<template>
  <div v-if="notifications.length">
    <table class="c-table">
      <tr>
        <td colspan="2">
          <button class="orange-btn normal-sq" @click.prevent="clearAll">{{ $trans.translation.clear_all }}</button>
          <button class="orange-btn normal-sq" @click.prevent="markAll">{{ $trans.translation.mark_all }}</button>
        </td>
      </tr>
      <tr :class="{'lightgrey-bg' : data.read}" v-for="(data, index) in notifications">
        <td>
          {{ $trans.translation.notification_title[data.type] + ' ' + data.body }}<br>
          <small>{{ data.created_at }}</small>
        </td>
        <td class="align-center font-15em">
          <a @click.prevent="markAsRead(data.id, index)" class="fas fa-check-square" :class="{'font-green' : data.read, 'font-grey' : !data.read}"></a>
        </td>
      </tr>
    </table>
  </div>
  <div v-else class="panel-body align-center">
    <h2 class="font-grey">{{ $trans.translation.notification_null }}</h2>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {

    }
  },
  computed: {
    ...mapGetters([
      'notifications',
      'notificationsRead'
    ])
  },
  methods: {
    ...mapActions([
      'markAllAsRead',
      'clearNotifications'
    ]),
    markAll() {
      if (!this.notificationsRead) {
        this.markAllAsRead()
        toastr.success(this.$trans.translation.saved)
      }
    },
    markAsRead(id, index) {
      if (!this.notifications[index].read) {
        this.$http.put(this.$root.url + '/profile/notifications/read', {id: id}).then(response => {
          this.$set(this.notifications[index], 'read', true)
          toastr.success(this.$trans.translation.saved)
        }, response => {
          toastr.error(this.$trans.translation.error)
        })
      }
    },
    clearAll() {
      this.$http.delete(this.$root.url + '/profile/notifications/delete').then(response => {
        toastr.success(this.$trans.translation.success)
        this.clearNotifications()
      }, response => {
        toastr.error(this.$trans.translation.error)
      })
    }
  }
}
</script>
