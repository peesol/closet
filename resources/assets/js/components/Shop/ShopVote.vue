<template>
<div v-if="$root.authenticated">
  <button class="s-vote" v-bind:class="{'s-vote-btn-voted': userVote == 'up'}" @click.prevent="vote('up')">{{ up > 1 ? $trans.translation.likes : $trans.translation.like }}&nbsp;{{ up }}
	</button>
  <button class="s-vote" v-bind:class="{'s-vote-btn-voted': userVote == 'down'}" @click.prevent="vote('down')">{{ down > 1 ? $trans.translation.dislikes : $trans.translation.dislike }}&nbsp;{{ down }}
	</button>
</div>
<div v-else>
  <button class="s-vote" @click.prevent="loginFirst">{{ up > 1 ? $trans.translation.likes : $trans.translation.like }}&nbsp;{{ up }}</button>
  <button class="s-vote" @click.prevent="loginFirst">{{ down > 1 ? $trans.translation.dislikes : $trans.translation.dislike }}&nbsp;{{ down }}</button>
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
