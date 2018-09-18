<template>
<div class="comments-wrap">
  <vue-progress-bar></vue-progress-bar>
  <div class="comments-header">
    <p>{{ comments.length }}&nbsp;{{ comments.length > 1 ? $trans.translation.comments : $trans.translation.comment }}</p>
  </div>
  <div class="panel-body" v-if="$root.authenticated" id="full-line">
    <textarea :placeholder="$trans.translation.comment+ '...'" class="comment-input" v-model="body"></textarea>
    <div class="align-right full-width padding-15-top">
      <button class="orange-btn normal-sq" type="submit" @click.prevent="createComment">{{$trans.translation.comment}}</button>
    </div>
  </div>
  <div v-for="comment in comments" class="panel-body">
    <div class="comments-thumb">
      <a v-bind:href="'/' + comment.shop.data.slug">
				<img class="round-btn" v-bind:src=" comment.shop.data.image" :alt="comment.shop.data.name">
			</a>
    </div>
    <div class="comments-body">
      <div class="comments-info">
        <p class="no-margin">
          <a class="link-text font-bold" v-bind:href="'/' + comment.shop.data.slug ">{{ comment.shop.data.name }}</a>&nbsp;{{ comment.created_at_human }}
        </p>
        <p class="comment">{{ comment.body }}</p>
      </div>
      <div class="comments-action">
        <a class="font-red margin-10-right" v-show="user_id === comment.user_id" @click.prevent="deleteComment(comment.id)">{{$trans.translation.delete}}</a>
        <a @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? $trans.translation.cancle : $trans.translation.reply }}</a>
        <a class="margin-10-left" v-show="showReply === comment.id && comment.replies.data.length" @click.prevent="toggleReply(comment.id)">{{ comment.replies.data.length > 1 ? $trans.translation.show_reply : $trans.translation.hide_reply }}&nbsp;<small class="icon-arrow-up"></small></a>
        <a class="margin-10-left" v-show="showReply !== comment.id && comment.replies.data.length" @click.prevent="toggleReply(comment.id)">{{ comment.replies.data.length > 1 ? $trans.translation.hide_reply : $trans.translation.show_reply }}&nbsp;<small class="icon-arrow-down"></small></a>
      </div>
      <transition name="slide-down-reply">
        <div class="input-group margin-10-top" v-show="replyFormVisible === comment.id">
          <input type="text" class="input-addon-field left" v-model="replyBody">
          <button class="input-addon right" @click.prevent="createReply(comment.id)"><span class="icon-next-arrow"></span></button>
        </div>
      </transition>
      <div class="replies-wrapper" v-if="showReply === comment.id" v-for="reply in comment.replies.data">
        <p class="no-margin">
          <a class="link-text" v-bind:href="'/' + reply.shop.data.slug ">{{ reply.shop.data.name }}</a>&nbsp;{{ reply.created_at_human }}
        </p>
        <div class="comments-area">
          <p class="comment">{{ reply.body }}</p>
        </div>
        <div v-show="user_id === reply.user_id" class="comments-action">
          <a class="font-red" @click.prevent="deleteComment(reply.id)">{{$trans.translation.delete}}</a>
        </div>
      </div>
    </div>

  </div>
</div>

</div>
</template>

<script>
export default {
  data() {
    return {
      comments: [],
      body: null,
      replyBody: null,
      replyFormVisible: null,
      showReply: null,
      user_id: window.Closet.user.user,
    }
  },
  props: {
    productUid: null
  },
  methods: {

    toggleReply(commentId) {

      if (this.showReply === commentId) {
        this.showReply = null;
        return;
      }

      this.showReply = commentId;
    },

    toggleReplyForm(commentId) {

      this.replyBody = null;

      if (this.replyFormVisible === commentId) {
        this.replyFormVisible = null;
        return;
      }

      this.replyFormVisible = commentId;
    },

    createReply(commentId) {

      this.$http.post(this.$root.url + '/product/' + this.productUid + '/comments', {
        body: this.replyBody,
        reply_id: commentId
      }).then((response) => {
        this.comments.map((comment, index) => {
          this.replyBody = null;
          if (comment.id === commentId) {
            this.comments[index].replies.data.push(response.body.data);
            this.toggleReplyForm(commentId);
            this.toggleReply(commentId);
          }
        })
      }, (response) => {
        toastr.error(response.body.body);
      });
    },

    createComment() {
      this.$http.post(this.$root.url + '/product/' + this.productUid + '/comments', {
        body: this.body
      }).then((response) => {
        this.comments.unshift(response.body.data);
        this.body = null;
      }, (response) => {
        toastr.error(response.body.body);
      });
    },

    deleteComment(commentId) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }

      this.$http.delete(this.$root.url + '/product/' + this.productUid + '/comments/' + commentId).then(() => {
        this.deleteById(commentId);
      });
    },

    deleteById(commentId) {

      this.comments.map((comment, index) => {
        if (comment.id === commentId) {
          this.comments.splice(index, 1);
          return;
        }

        comment.replies.data.map((reply, replyIndex) => {
          if (reply.id === commentId) {
            this.comments[index].replies.data.splice(replyIndex, 1);
            return;
          }
        })
      });

    },

    getComments() {
      this.$Progress.start()
      this.$http.get(this.$root.url + '/product/' + this.productUid + '/comments').then((response) => {
        this.comments = response.body.data
        this.$Progress.finish()
      });
    },
  },
  watch: {
    '$root.tab' : {
      handler() {
        if (this.$root.tab == 'comment') {
          this.getComments()
        }
      }
    }
  }
}
</script>
