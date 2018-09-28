<template>
  <button class="dropdown-btn" @click.prevent="clicked">
    <i class="fas fa-bell" :class="{'font-orange' : notificationCount > 0}">&nbsp;<font>{{ notificationCount }}</font></i>
  </button>
</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      datas: []
    }
  },
  props: [
    'element'
  ],
  computed: {
    ...mapGetters([
      'notificationCount',
      'notifications'
    ])
  },
  methods: {
    ...mapActions([
      'getNotification',
      'addNotification'
    ]),
    clicked(event) {
      if (this.element == 'footer') {
        document.location.href = this.$root.url + '/profile/notifications'
      }
      this.$emit('clicked', true)
    }
  },
  created() {
    if (this.element == 'nav') {
      this.getNotification()
      Echo.private('users.' + this.$root.user)
      .notification((notification) => {
          this.addNotification({ notification })
      })
    }
  }
}
</script>
