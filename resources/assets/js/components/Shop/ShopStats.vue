<template>
	                <div class="shop-stats">
                        <ul class="shop-info-ul">
                            <li class="shop-info-li">{{productsCount}}&nbsp;{{ productsCount > 1 ? $trans.translation.products : $trans.translation.product }}</li>
                            <li class="shop-info-li">{{followers}}&nbsp;{{ followers > 1 ? $trans.translation.followers : $trans.translation.follower }}</li>
                        </ul>
                    </div>
</template>

<script>
	export default{
		data() {
			return {
				productsCount: null,
				followers: null,
				up:null,
				down:null,
        url: window.Closet.url,
				trans: this.$trans,
			}
		},
		props: {
			shopSlug: null
		},
		methods: {
    		getStats () {
    			this.$http.get(this.url + '/' + this.shopSlug + '/status').then((response) => {
    				return response.json()
  					.then((parsed) => {
  					  this.up = parsed.up;
  					  this.down = parsed.down;
  					  this.productsCount = parsed.products;
  					  this.followers = parsed.follows;
  					});

    			});
    		},

    	},

    	created() {
    		this.getStats();
  		}

	}
</script>
