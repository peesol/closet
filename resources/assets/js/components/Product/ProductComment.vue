<template>
<div class="comments-wrap">
	<div class="comments-header">
	<p>{{ comments.length }}&nbsp;{{ comments.length > 1 ? $trans.translation.comments : $trans.translation.comment }}</p>
	</div>

	<div class="comments-field-wrap" v-if="$root.user.authenticated">
		<textarea placeholder="" class="comments-field" v-model="body"></textarea>
		<button class="btn float-right" type="submit" @click.prevent="createComment">{{$trans.translation.comment}}</button>
	</div>
	<div id="full-line"></div>
	<ul style="display: inline-block;">
	<li v-for="comment in comments" style="list-style-type:none;">
		<div class="comments-thumb">
			<a class="link-text" v-bind:href="'/' + comment.shop.data.slug ">
				<img class="" v-bind:src=" comment.shop.data.image" :alt=" comment.shop.data.name">
			</a>
		</div>
		<div class="comments-body margin-bot-10px">
			<a class="link-text float-left " v-bind:href="'/' + comment.shop.data.slug ">{{ comment.shop.data.name }}</a>&nbsp;
			<p class="comments-time">{{ comment.created_at_human }}</p>
			<div class="comments-area"><p class="comment">{{ comment.body }}</p></div>


			<div v-if="$root.user.authenticated" class="reply-list-wrap">
			<ul style="padding: 0;">
				<li class="reply-list">
					<a class="link-text" href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? $trans.translation.cancle : $trans.translation.reply }}</a>
				</li>
				<li v-if="user_id === comment.user_id" class="reply-list">
					<a class="link-text margin-left-10px" href="#" @click.prevent="deleteComment(comment.id)">{{$trans.translation.delete}}</a>
				</li>
			</ul>
			</div>
			<transition name="slide-down-reply">
			<div class="reply-field-wrap margin-bot-10px" v-if="replyFormVisible === comment.id">
				<textarea class="reply-field" v-model="replyBody"></textarea>
				<button class="btn float-right" type="submit" @click.prevent="createReply(comment.id)">{{$trans.translation.reply}}</button>
			</div>
			</transition>

			<div class="margin-bot-10px" v-if="comment.replies.data.length > 0">
				<a class="link-text" href="#" v-if="showReply === comment.id" @click.prevent="toggleReply(comment.id)">{{ comment.replies.data.length > 1 ? $trans.translation.show_reply : $trans.translation.hide_reply }}&nbsp;<span style="font-size: 10px;" class="icon-arrows"></span></a>
				<a class="link-text" href="#" v-if="showReply !== comment.id" @click.prevent="toggleReply(comment.id)">{{ comment.replies.data.length > 1 ? $trans.translation.hide_reply : $trans.translation.show_reply }}&nbsp;<span style="font-size: 10px;" class="icon-arrows-1"></span></a>
				</div>


			<div class="reply" v-if="showReply === comment.id" v-for="reply in comment.replies.data">
				<div class="reply-body">
					<div class="reply-thumb">
						<a class="link-text float-left" v-bind:href="'/' + reply.shop.data.slug ">
							<img class="" v-bind:src=" reply.shop.data.image " :alt=" reply.shop.data.name">
						</a>
					</div>

						<div class="reply-body-wrap">
							<a class="link-text float-left" v-bind:href="'/' + reply.shop.data.slug ">{{ reply.shop.data.name }}</a>&nbsp;
							<p class="comments-time">{{ reply.created_at_human }}</p>
							<div class="comments-area"><p class="comment">{{ reply.body }}</p></div>
						</div>

					<div v-if="user_id === reply.user_id" class="reply-list-wrap">
						<ul>
							<li class="reply-list">
								<a class="link-text float-left" href="#" @click.prevent="deleteComment(reply.id)">{{$trans.translation.delete}}</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--reply -->
		</div>
	</li>
	</ul>

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
				url: window.Closet.url,
        user_id: window.Closet.user.user
			}
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

				this.$http.post(this.url + '/product/' + this.productUid + '/comments', {
					body: this.replyBody,
					reply_id: commentId
				}).then((response)=> {
					return response.json()
						.then((json) => {
							this.comments.map((comment, index) => {
								this.replyBody = null;
								if(comment.id === commentId) {
									this.comments[index].replies.data.push(json.data);
									this.toggleReplyForm(commentId);
									this.toggleReply(commentId);
								}
							})
  						});
				});
			},

			createComment() {
				this.$http.post(this.url + '/product/' + this.productUid + '/comments', {
					body: this.body
				}).then((response)=> {
					return response.json()
						.then((json) => {
  						  	this.body = null;
  						  	this.getComments();
  						});
				});

			},

			deleteComment(commentId) {
				if(!confirm(this.$trans.translation.comment_delete_confirm)){
					return;
				}

				this.$http.delete(this.url + '/product/' + this.productUid + '/comments/' + commentId).then(() => {
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
  					this.$http.get(this.url + '/product/' + this.productUid + '/comments' ).then((response)=> {
						return response.json()
						.then((json) => {
							this.comments = json.data;
  						});
				});

			},
		},

		props: {
        	productUid: null
        },

		created() {
			this.getComments();
		}
	}
</script>
