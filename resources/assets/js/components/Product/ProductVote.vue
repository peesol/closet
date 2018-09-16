<template>
<div v-if="$root.authenticated">
  <div class="vote">
    <button class="vote-btn" v-bind:class="{'vote-btn-voted': userVote == 'up'}" @click.prevent="vote('up')">
			<span class="icon-heart"></span>&nbsp;{{ up }}
		</button>
  </div>
  <div class="vote">
    <button class="vote-btn" v-bind:class="{'vote-btn-voted': userVote == 'down'}" @click.prevent="vote('down')">
			<span class="icon-heart-broken"></span>&nbsp;{{ down }}
		</button>
  </div>
</div>
<div v-else>
  <div class="vote">
    <button class="vote-btn" @click.prevent="loginFirst">
      <span class="icon-heart"></span>
    </button>&nbsp;{{ up }}
  </div>
  <div class="vote">
    <button class="vote-btn" @click.prevent="loginFirst">
      <span class="icon-heart-broken"></span>
    </button>&nbsp;{{ down }}
  </div>
</div>
</template>

<script>
export default {

  data() {
    return {
      up: null,
      down: null,
      userVote: null
    }
  },

  methods: {
    getVotes() {
      this.$http.get(this.$root.url + '/product/' + this.productUid + '/votes').then(response => {
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
      this.$http.delete(this.$root.url + '/product/' + this.productUid + '/votes');

    },

    createVote(type) {
      this.$http.post(this.$root.url + '/product/' + this.productUid + '/votes', {
        type: type,
      });

    },

    loginFirst() {
      toastr.warning(this.$trans.translation.login_first)
    },

    logView() {
      this.$http.put(this.$root.url + '/product/' + this.productUid + '/views', {
        product_id: this.productUid
      });
      clearInterval(this.timer);
    }
  },

  props: {
    productUid: null,
    productId: null,
  },

  created() {
    this.getVotes();
  },

  mounted() {
    this.timer = setInterval(this.logView, 7000);
  }

}
</script>
