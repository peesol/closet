<template>
<div class="follow-btn-wrap" v-if="canFollow">
  <button v-if="userFollowed === false" @click.prevent="handle" class="follow-btn follow">{{$trans.translation.follow}}</button>
  <button v-else @click.prevent="handle" class="follow-btn unfollow">{{$trans.translation.unfollow}}</button>
</div>
</template>

<script>
export default {
  data() {
    return {
      followers: null,
      userFollowed: false,
      canFollow: false,
    }
  },

  props: {
    shopSlug: null
  },
  methods: {
    getFollowStatus() {
      this.$http.get(this.$root.url + '/follow/' + this.shopSlug)
        .then(response => {
          this.followers = response.data.data.count;
          this.userFollowed = response.data.data.user_followed;
          this.canFollow = response.data.data.can_follow;
        })
    },

    handle() {
      if (this.userFollowed) {
        this.unfollow();
      } else {
        this.follow();
      }

    },
    follow() {
      this.userFollowed = true;
      this.followers++;
      this.$http.post(this.$root.url + '/follow/' + this.shopSlug);
    },
    unfollow() {
      if (!confirm('Are you sure you want to unfollow?')) {
        return;
      }
      this.userFollowed = false;
      this.followers--;
      this.$http.delete(this.$root.url + '/follow/' + this.shopSlug);
    }
  },

  created() {
    this.getFollowStatus();
  }
}
</script>
