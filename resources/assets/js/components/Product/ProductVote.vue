<template>
<div v-if="user !== null">
	<div class="vote">
		<a href="#" class="vote-btn" v-bind:class="{'vote-btn-voted': userVote == 'up'}" @click.prevent="vote('up')">
			<span class="icon-heart"></span>
		</a> {{ up }}
	</div>
	<div class="vote">
		<a href="#" class="vote-btn" v-bind:class="{'vote-btn-voted': userVote == 'down'}" @click.prevent="vote('down')">
			<span class="icon-heart-broken"></span>
		</a> {{ down }}
	</div>
</div>
<div v-else>
    <div class="vote">
        <a class="vote-btn" @click.prevent="loginFirst">
            <span class="icon-heart"></span>
        </a> {{ up }}
    </div>
    <div class="vote">
        <a class="vote-btn" @click.prevent="loginFirst">
            <span class="icon-heart-broken"></span>
        </a> {{ down }}
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
                url: window.Closet.url,
                user: window.Closet.user.user,
    		}
    	},


    	methods: {
    		getVotes () {
    			this.$http.get(this.url + '/product/' + this.productUid + '/votes').then((response) => {
    				return response.json()
  					.then((parsed) => {
  					  this.up = parsed.data.up;
  					  this.down = parsed.data.down;
  					  this.userVote = parsed.data.user_vote;
  					});

    			});
    		},

    		vote (type) {
    			if (this.userVote == type) {
    				this[type]--;
    				this.userVote = null;
    				this.deleteVote(type);
    				return;
    			}

    			if(this.userVote) {
    				this[type == 'up' ? 'down' : 'up']--;
    			}

    			this[type]++;
    			this.userVote = type;

    			this.createVote(type);
    		},

    		deleteVote(type) {
    			this.$http.delete(this.url + '/product/' + this.productUid + '/votes');

    		},

    		createVote(type) {
    			this.$http.post(this.url + '/product/' + this.productUid + '/votes', {
    				type: type,
    			});

    		},

            loginFirst() {
                toastr.warning(this.$trans.translation.login_first,
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                            "timeOut": "1000",
                        }
                    );
            },

            logView() {
                this.$http.put(this.url + '/product/' + this.productUid + '/views', { product_id: this.productUid });
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
