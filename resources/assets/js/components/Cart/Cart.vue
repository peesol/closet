<template>
	<div>
		<vue-progress-bar></vue-progress-bar>
		<div class="panel-heading">
			<label class="heading">{{$trans.translation.cart}}</label>
			<button v-show="Object.keys(products).length" class="flat-btn float-right font-15em" @click="clearCart()">{{$trans.translation.cart_clear}}&nbsp;<i class="fas fa-times"></i></button>
		</div>
		<div class="relative">
			<load-overlay bg="white-bg" :show="!loaded"></load-overlay>
			<div class="panel-body-res" v-for="shop, key in products" v-if="products.length || Object.keys(products).length">
				<div class="color-heading">
					<strong>{{key}}</strong>
				</div>
				<div id="full-line" class="col-2-flex-res padding-10" v-for="(item, index) in shop">
					<div class="text-row">
						<button v-show="confirmed.shop !== key" class="fas fa-times flat-btn delete" @click.prevent="removeProduct(item.rowId, index, item.options.shop_name)"></button>
						&nbsp;{{item.name}}&nbsp;<small>{{item.options.choice ? item.options.choice : ''}}</small>small
					</div>
					<div class="text-row">
						{{$trans.translation.price}}&nbsp;{{$number.currency(item.price)}}&nbsp;฿
						<div class="input-group qty-input float-right">
							<button :disabled="confirmed.shop == key" type="button" @click.prevent="addQty(1, item , index)">-</button>
							<input :disabled="confirmed.shop == key" type="number" min="1" :max="item.options.stock" @input.prevent="qtyChange(item, index, shop)" v-model="item.qty">
							<button :disabled="confirmed.shop == key" type="button" @click.prevent="addQty(2, item, index)">+</button>
						</div>
					</div>
				</div>
				<div id="full-line" class="padding-10 flex">
					<div class="half-width">
							<strong class="font-large">{{$trans.translation.total_price}}&nbsp;:&nbsp;{{ total(shop) }}&nbsp;฿</strong><br>
							<span class="font-green bold-font" v-show="confirmed.discount">{{$trans.translation.discount}}&nbsp;{{confirmed.discount}}&nbsp;(-{{confirmed.totalDiscount}}&nbsp;฿)</span>
					</div>
					<div class="half-width align-right">
						<button :disabled="confirmed.totalQty < 1" v-show="confirmed.shop !== key" class="default width-120" @click.prevent="proceed(key, total(shop), shop[0].options.shop_id)">{{$trans.translation.confirm_order}}</button>
					</div>
				</div>
				<div class="padding-10" v-show="confirmed.shop == key">
					<div v-show="confirmed.discountApplied === false" class="half-width-res">
						<label class="input-label">{{$trans.translation.apply_discount}}</label>
						<div class="half-width-res input-group padding-5">
							<input class="input-addon-field left" v-model="code" type="text" placeholder="CODE">
							<button :disabled="$root.loading" @click.prevent="applyDiscount(shop[0].options.shop_id)" type="button" class="input-addon right form-input-btn checkmark-btn"><i class="fas fa-check"></i></button>
						</div>
					</div>
						<label class="input-label">{{$trans.translation.shipping}}</label><br>
						<span class="font-green">{{ current_promotion }}</span>
						<form @submit.prevent="confirmOrder(shop, key)" class="relative">
						<load-overlay bg="white-bg" :show="loadShipping"></load-overlay>
						<li class="list-no-style padding-5" v-for="item, index in shippingChoice">
							<input required @click="includeFee()" name="shipping" :id="index" type="radio" :value="item" v-model="confirmed.shipping">
							<label :for="index">
								{{ item.method }}&nbsp;{{$trans.translation.shipping_time}}&nbsp;{{item.time}}&nbsp;{{$trans.translation.days}}&nbsp;{{ item.free ? 'free' : item.fee + '฿' }}
								&nbsp;{{ item.multiply ? '+' + item.multiply_by + ' ฿ ' + $trans.translation.multiply_by : ''}}
							</label>
						</li>
						<div class="full-width padding-10" v-show="confirmedTotal !== null">
							<h3 class="font-green no-margin">{{$trans.translation.total_shipping}}&nbsp;{{ confirmedTotal }}&nbsp;฿</h3>
						</div>
							<label class="input-label margin-10-bottom">{{$trans.translation.address}}&nbsp;
								<a v-show="user.phone && user.address" class="font-medium" @click.prevent="addressEdit = !addressEdit">{{ $trans.translation.address_edit }}</a>
							</label>
							<div v-show="!addressEdit && user.phone && user.address" class="padding-5 half-width-res lightgrey-bg padding-5">
								{{ user.name }}<br>
								{{ user.address }}<br>
								{{ $trans.translation.phone + ' ' + user.phone }}<br>
							</div>
							<div v-show="addressEdit || !user.phone || !user.address" class="padding-10 half-width-res shadow-2">
								<div class="form-group">
									<input :required="addressEdit || !user.phone || !user.address" class="form-input full-width" type="text" v-model="user.name" :placeholder="$trans.translation.name">
								</div>
								<div class="form-group">
									<textarea :required="addressEdit || !user.phone || !user.address" class="comment-input" type="text" v-model="user.address" :placeholder="$trans.translation.address"></textarea>
								</div>
								<div class="form-group">
									<input :required="addressEdit || !user.phone || !user.address" class="form-input full-width" type="text" v-model="user.phone" :placeholder="$trans.translation.phone">
								</div>
							</div>
						<div class="align-right padding-15-top">
							<button :disabled="$root.loading" class="green-btn border-radius-5 width-120-res" type="submit">{{$trans.translation.place_order}}</button>
						</div>
						</form>
				</div>
			</div>
			<div v-else class="panel-body align-center">
				<h2 class="font-grey">{{$trans.translation.product_none}}</h2>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
	data() {
		return {
			addressEdit: false,
			shippingChoice: null,
			shippingPromotion: null,
			confirmed: {
				shop: null,
				totalPrice: null,
				discount: null,
				discountApplied: false,
				totalDiscount: null,
				shipping: null,
				totalQty: null,
			},
			confirmedTotal: null,
			shippingFee: null,
			code: null,
			products: [],
			loaded: false,
			loadShipping: false,
			checkout: false,
			fill_address: false
		}
	},
	props: ['user'],
	watch: {
		'confirmed.discountApplied' : {
			handler() {
				this.includeFee()
			}
		}
	},
	computed: {
		current_promotion() {
			if (this.checkout && Object.keys(this.shippingPromotion).length) {
				return this.$trans.translation.shipping_promotion_input.label + ' ' + this.$number.currency(this.shippingPromotion.amount) + ' ' + this.$trans.translation.shipping_promotion_input[this.shippingPromotion.type]
			}
		}
	},
	methods: {
		includeFee() {
			let price  = [];
			var oldPrice = parseInt(this.confirmed.totalPrice.replace(/[^0-9]/g, ''), 10)
			if (!this.confirmed.shipping.free) {
				price.push(oldPrice)
				price.push(this.confirmed.shipping.fee)
				var feeIncluded = price.reduce(function(total, num){ return total + num }, 0)
				if (this.confirmed.shipping.multiply) {
					var multiply = this.confirmed.shipping.multiply_by * [this.confirmed.totalQty - 1]
					var totalMultiply = feeIncluded + multiply
					this.shippingFee = this.confirmed.shipping.fee + multiply
					//calculate multiply
					if (Object.keys(this.shippingPromotion).length) {
						var promotionFee = totalMultiply - this.shippingFee
						if (this.shippingPromotion.type == 'cost' && oldPrice >=  this.shippingPromotion.amount) {
							this.shippingFee = 0
							this.confirmedTotal = this.$number.currency(promotionFee)
						} else if (this.shippingPromotion.type == 'qty' && this.confirmed.totalQty >=  this.shippingPromotion.amount) {
							this.shippingFee = 0
							this.confirmedTotal = this.$number.currency(promotionFee)
						} else {
							this.confirmedTotal = this.$number.currency(totalMultiply)
						}
					} else {
						this.confirmedTotal = this.$number.currency(totalMultiply)
					}
				} else {
					if (Object.keys(this.shippingPromotion).length) {
						var promotionFee = feeIncluded - this.confirmed.shipping.fee
						if (this.shippingPromotion.type == 'cost' && oldPrice >=  this.shippingPromotion.amount) {
							this.shippingFee = 0
							this.confirmedTotal = this.$number.currency(promotionFee)
						} else if (this.shippingPromotion.type == 'qty' && this.confirmed.totalQty >=  this.shippingPromotion.amount) {
							this.shippingFee = 0
							this.confirmedTotal = this.$number.currency(promotionFee)
						} else {
							this.confirmedTotal = this.$number.currency(feeIncluded)
						}
					} else {
						this.shippingFee = this.confirmed.shipping.fee
						this.confirmedTotal = this.$number.currency(feeIncluded)
					}
				}
			} else { //free shipping
				this.confirmedTotal = this.confirmed.totalPrice
			}
		},
		total: function(shop) {
			let totalPrice = [];
			let totalQty = [];
			Object.entries(shop).forEach(([key, val]) => {
					var subTotal = val.price * val.qty
					totalPrice.push(subTotal)
					totalQty = val.qty
			});
			var total = totalPrice.reduce(function(total, num){ return total + num }, 0);
			this.confirmed.totalQty = totalQty
			if (this.confirmed.discountApplied) {
				return this.confirmed.totalPrice
			} else {
				return this.$number.currency(total)
			}

		},
		...mapActions([
			'removeFromCart',
		]),
		getCart() {
			this.$http.get(this.$root.url + '/cart/get_shop').then((response) => {
				this.loaded = true
				this.products = response.data
			});
		},
		qtyChange(item) {
			if (item.qty > item.options.stock) {
				alert(this.$trans.translation.stock_remain + ' ' + item.options.stock)
				item.qty = item.options.stock
			} else {
				this.$http.put(this.$root.url + '/cart/update/qty', {rowId: item.rowId, qty: item.qty});
			}
		},
		removeProduct(id, index, shop) {
			this.removeFromCart()
			if (!confirm(this.$trans.translation.delete_confirm)) {
				return
			} else {
				return this.$http.put(this.$root.url + '/cart/remove/' + id, {rowId: id}).then((response) => {
					this.products[shop].splice(index, 1)
					if(this.products[shop].length === 0) {
						this.$delete(this.products, shop)
					}
				});
			}
		},
		proceed(key, total, id) {
			if (!confirm(this.$trans.translation.confirm_order_notice)) {
				return
			} else {
			if (this.confirmed.shop === key){
				_.mapValues(this.confirmed, () => null);
				return;
			}
			this.confirmed.shop = key;
			this.confirmed.totalPrice = total;
			this.loadShipping = true
			this.confirmed.discountApplied = false
			this.confirmed.discount = null
			this.confirmed.totalDiscount = null
			this.$Progress.start()
			this.$http.get(this.$root.url + '/api/getter/shipping_info/' + id).then(response => {
				this.shippingChoice = response.body.methods
				this.shippingPromotion = response.body.promotion ? response.body.promotion[0] : {}
				this.loadShipping = false
				this.checkout = true
				this.$Progress.finish()
			}, response => {
				this.loadShipping = false
				this.$Progress.fail()
			})
			}
		},
		confirmOrder(shop, key) {
			if (!confirm(this.$trans.translation.confirm_order + '?')) {
				return
			} else {
				this.$Progress.start()
				this.loaded = false
				this.checkout = false
				return this.$http.post(this.$root.url + '/order/sending', {
					products: shop,
					sender_id: this.user.id,
					sender_name: this.user.name,
					reciever_name: key,
					address:  this.user.address,
					phone: this.user.phone,
					products_total: this.confirmed.totalPrice,
					include_shipping: this.confirmedTotal,
					discount: this.confirmed.discount,
					shipping: this.confirmed.shipping,
					shipping_fee: this.shippingFee,
					fill_address: this.fill_address,
				}).then(response => {
					this.$delete(this.products, key)
					_.mapValues(this.confirmed, () => null);
					window.location.href = this.$root.url + '/order/' + response.body
					this.$Progress.finish()
					this.loaded = false
				}, response => {
					this.$Progress.fail()
					this.loaded = false
					toastr.error(this.$trans.translation.error)
				});
			}
		},
		applyDiscount(id) {
			this.$root.loading = true
				this.$http.post(this.$root.url + '/promotions/code/validate', {code: this.code, shop_id: id}).then(response => {
					this.$root.loading = false
					if (response.body.status === true) {
						if (response.body.type == 'percent') {
							var price = this.confirmed.totalPrice.split(',').join('')
							var calculated = price - ((response.body.discount / 100) * price).toFixed(0)
							if (calculated < 0) {
								alert(this.$trans.translation.discount_not_valid)
								this.code = null
							} else {
								this.confirmed.totalDiscount = ((response.body.discount / 100) * price).toFixed(0)
								this.confirmed.totalPrice = this.$number.currency(calculated)
								this.confirmed.discount = response.body.discount + '%'
								this.confirmed.discountApplied = true

								this.code = null
							}
						} else if (response.body.type == 'baht') {
							var price = this.confirmed.totalPrice.split(',').join('')
							var calculated = price - response.body.discount
							if (calculated < 0) {
								alert(this.$trans.translation.discount_not_valid)
								this.code = null
							} else {
								this.confirmed.totalDiscount = response.body.discount
								this.confirmed.totalPrice = this.$number.currency(calculated)
								this.confirmed.discount = response.body.discount + ' ฿'
								this.confirmed.discountApplied = true
								this.code = null
							}
						}
					} else {
						this.confirmed.discountApplied = false
						alert(this.$trans.translation.discount_not_valid)
					}
				}, response => {
					this.$root.loading = false
					toastr.error(this.$trans.translation.error);
				});
		},
		clearCart() {
			if (!confirm(this.$trans.translation.delete_confirm)) {
				return
			} else {
				this.$root.loading = true
				this.$http.put(this.$root.url + '/cart/mycart/clear').then(response => {
					this.products = []
					this.$root.loading = false
				}, response => {
					this.products = []
					this.$root.loading = false
				})
			}
		},
		addQty(type, item) {
				if (type === 1) {
					if (item.qty > 0) {
						item.qty = --item.qty
						this.qtyChange(item)
					}
				} else {
					item.qty = ++item.qty
					this.qtyChange(item)
				}
		},
		back() {
			_.mapValues(this.confirmed, () => null);
		}
	},
	mounted() {
		this.getCart();
		if (!this.user.address || !this.user.phone) {
			this.fill_address = true
		}
	}
}
</script>
