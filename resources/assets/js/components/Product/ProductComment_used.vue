<template>
<div class="comments-wrap">
	<vue-progress-bar></vue-progress-bar>
	<div class="comments-header">
	<p>{{ comments.length }}&nbsp;{{ comments.length > 1 ? $trans.translation.comments : $trans.translation.comment }}</p>
	</div>
	<div class="panel-body relative" v-if="$root.authenticated"  id="full-line">
		<textarea :placeholder="$trans.translation.comment+ '...'" class="description-input" v-model="body" style="height:100px;"></textarea>
		<button class="btn margin-top-10px" style="margin-left:auto;display:block;" type="submit" @click.prevent="createComment">{{$trans.translation.comment}}</button>
	</div>

	<div v-for="comment in comments" class="panel-body">
		<div class="comments-thumb">
			<a v-bind:href="'/' + comment.shop.data.slug"><img class="round-btn" v-bind:src=" comment.shop.data.image" :alt=" comment.shop.data.name"></a>
		</div>
		<div class="comments-body">
			<div class="comments-info">
				<p class="no-margin"><a class="link-text font-bold" v-bind:href="'/' + comment.shop.data.slug ">{{ comment.shop.data.name }}</a>&nbsp;{{ comment.created_at_human }}</p>
				<p class="comment">{{ comment.body }}</p>
			</div>
			<div class="comments-action">
				<font v-show="user_id === comment.user_id" class="link-text" @click.prevent="deleteComment(comment.id)">{{$trans.translation.delete}}</font>
				<font class="link-text" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? $trans.translation.cancle : $trans.translation.reply }}</font>
			</div>
			<transition name="slide-down-reply">
			<div class="input-group margin-top-10px" v-show="replyFormVisible === comment.id">
				<input type="text" class="input-addon-field" v-model="replyBody">
				<button class="input-addon" @click.prevent="createReply(comment.id)"><span class="icon-next-arrow"></span></button>
			</div>
			</transition>
			<div class="full-label" v-if="comment.replies.data.length">
				<font class="link-text" v-show="showReply === comment.id" @click.prevent="toggleReply(comment.id)">{{ comment.replies.data.length > 1 ? $trans.translation.show_reply : $trans.translation.hide_reply }}&nbsp;<span style="font-size: 10px;" class="icon-arrows-up"></span></font>
				<font class="link-text" v-show="showReply !== comment.id" @click.prevent="toggleReply(comment.id)">{{ comment.replies.data.length > 1 ? $trans.translation.hide_reply : $trans.translation.show_reply }}&nbsp;<span style="font-size: 10px;" class="icon-arrows-down"></span></font>
			</div>
			<div v-if="showReply === comment.id" v-for="reply in comment.replies.data">
					<div class="comments-thumb">
						<a class="link-text" v-bind:href="'/' + reply.shop.data.slug ">
							<img class="round-btn" v-bind:src=" reply.shop.data.image " :alt=" reply.shop.data.name">
						</a>
					</div>
						<div class="comments-body">
							<p class="no-margin"><a class="link-text" v-bind:href="'/' + reply.shop.data.slug ">{{ reply.shop.data.name }}</a>&nbsp;{{ reply.created_at_human }}</p>
							<div class="comments-area"><p class="comment">{{ reply.body }}</p></div>
							<div v-show="user_id === reply.user_id" class="reply-list-wrap">
								<font class="link-text" @click.prevent="deleteComment(reply.id)">{{$trans.translation.delete}}</font>
							</div>
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

				if (this.showReply === commentId){
					this.showReply = null;
					return;
				}

				this.showReply = commentId;
			},

			toggleReplyForm(commentId) {

				this.replyBody = null;

				if (this.replyFormVisible === commentId){
					this.replyFormVisible = null;
					return;
				}

				this.replyFormVisible = commentId;
			},

			createReply(commentId) {

				this.$http.post(this.$root.url + '/product/used/' + this.productUid + '/comments', {
					body: this.replyBody,
					reply_id: commentId
				}).then((response)=> {
							this.comments.map((comment, index) => {
								this.replyBody = null;
								if(comment.id === commentId) {
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
				this.$http.post(this.$root.url + '/product/used/' + this.productUid + '/comments', {
					body: this.body
				}).then((response)=> {
						this.comments.unshift(response.body.data);
  					this.body = null;
				}, (response) => {
            toastr.error(response.body.body);
        });
			},

			deleteComment(commentId) {
				if(!confirm(this.$trans.translation.comment_delete_confirm)){
					return;
				}

				this.$http.delete(this.$root.url + '/product/used/' + this.productUid + '/comments/' + commentId).then(() => {
					this.deleteById(commentId);
				});
			},

			deleteById(commentId) {

				this.comments.map((comment, index)=> {
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
						this.$Progress.start();
  					this.$http.get(this.$root.url + '/product/used/' + this.productUid + '/comments' ).then((response)=> {
						this.comments = response.body.data;
						this.$Progress.finish();
				});

			},
		},
		created() {
			this.getComments()
		}
	}
</script>
