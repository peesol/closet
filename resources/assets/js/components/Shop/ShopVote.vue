<template>
<div class="flex" v-if="$root.authenticated">
  <div class="half-width">
    <button class="profile-vote-btn font-15em" v-bind:class="{'profile-voted-btn': userVote == 'up'}" @click.prevent="vote('up')">
      <span class="icon-heart">&nbsp;<font class="font-large">{{ up }}</font></span>
    </button>
  </div>
  <div class="half-width align-right">
    <button class="profile-vote-btn font-15em" v-bind:class="{'profile-voted-btn': userVote == 'down'}" @click.prevent="vote('down')">
        <span class="icon-heart-broken">&nbsp;<font class="font-large">{{ down }}</font></span>
    </button>
  </div>
</div>
<div v-else class="flex">
  <div class="half-width">
    <button class="profile-vote-btn font-15em" @click.prevent="loginFirst">
      <span class="icon-heart">&nbsp;<font class="font-large">{{ up }}</font></span>
    </button>
  </div>
  <div class="half-width align-right">
    <button class="profile-vote-btn font-15em" @click.prevent="loginFirst">
        <span class="icon-heart-broken">&nbsp;<font class="font-large">{{ down }}</font></span>
    </button>
  </div>
</div>
</template>

<script>
export default {

  data() {
    return {
      up: null,
      down: null,
      userVote: null,
    }
  },
  props: {
    shopSlug: null,
  },
  methods: {
    getVotes() {
      this.$http.get(this.$root.url + '/' + this.shopSlug + '/votes').then((response) => {
        this.up = response.body.data.up;
        this.down = response.body.data.down;
        this.userVote = response.body.data.user_vote;
      });
    },
    vote(type) {
      if (this.userVote == type) {
        this[type]--;
        this.userVote = null;
        this.deleteVote(type);
        return;
      }

      if (this.userVote) {
        this[type == 'up' ? 'down' : 'up']--;
      }

      this[type]++;
      this.userVote = type;

      this.createVote(type);
    },

    deleteVote(type) {
      this.$http.delete(this.$root.url + '/' + this.shopSlug + '/votes');

    },

    createVote(type) {
      this.$http.post(this.$root.url + '/' + this.shopSlug + '/votes', {
        type: type,
      });

    },
    loginFirst() {
      toastr.warning(this.$trans.translation.login_first)
    },

    logView() {
      this.$http.put(this.$root.url + '/' + this.shopSlug + '/views');
      clearInterval(this.timer);
    }
  },

  created() {
    this.getVotes();
  },
  mounted() {
    this.timer = setInterval(this.logView, 10000);
  }
}
</script>
