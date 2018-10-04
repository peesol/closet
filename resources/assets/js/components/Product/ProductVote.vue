<template>
<div>
  <div class="vote">
    <button class="vote-btn" v-bind:class="{'vote-btn-voted': userVote == 'up'}" @click.prevent="vote('up')">
			<i class="fas fa-heart fa-stack"></i>&nbsp;{{ up }}
		</button>
  </div>
  <div class="vote">
    <button class="vote-btn" v-bind:class="{'vote-btn-voted': userVote == 'down'}" @click.prevent="vote('down')">
      <span class="fa-stack">
        <i class="fa fa-heart fa-stack-1x"></i>
        <i class="fa fa-bolt fa-stack-1x fa-inverse"></i>
      </span>&nbsp;{{ down }}
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
      if (this.$root.authenticated) {
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
      } else {
        toastr.warning(this.$trans.translation.login_first)
      }
    },

    deleteVote(type) {
      this.$http.delete(this.$root.url + '/product/' + this.productUid + '/votes');

    },

    createVote(type) {
      this.$http.post(this.$root.url + '/product/' + this.productUid + '/votes', {
        type: type,
      });

    },
    logView() {
      this.$http.put(this.$root.url + '/product/' + this.productUid + '/views');
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
    setTimeout(this.logView, 7000);
  }

}
</script>
