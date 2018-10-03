<template>
	<div class="relative">
		<vue-progress-bar></vue-progress-bar>
		<load-overlay bg="white-bg" :show="!loaded"></load-overlay>
		<div class="overflow-x-auto">
			<table v-show="!products.length" class="c-table overflow-x-auto" v-for="shop, key in products">
				<tr class="orange-bg">
					<td colspan="4"><strong class="font-grey font-white">{{key}}</strong></td>
				</tr>
				<tr class="cart">
					<th>{{$trans.translation.product_name}}</th>
					<th>{{$trans.translation.choice}}</th>
					<th>{{$trans.translation.price}}</th>
					<th>{{$trans.translation.amount}}</th>
				</tr>
				<tr v-for="(item, index) in shop">
					<td class="overflow-hidden">
						<button v-show="confirmed.shop !== key" class="fas fa-times flat-btn delete" @click.prevent="removeProduct(item.rowId, index, item.options.shop_name)"></button>&nbsp;{{item.name}}
					</td>
					<td class="m-cell overflow-hidden">{{item.options.choice ? item.options.choice : '---'}}</td>
					<td class="s-cell">{{$number.currency(item.price)}}</td>
					<td class="s-cell"><input :disabled="confirmed.shop == key" type="number" min="1" :max="item.options.stock" @change.prevent="qtyChange(item, index, shop)" v-model="item.qty"></td>
				</tr>
				<tr v-show="confirmed.shop !== key">
					<td colspan="2" class="total-price">
						<strong>{{$trans.translation.total_price}}&nbsp;:&nbsp;{{total(shop)}}</strong>฿
					</td>
					<td colspan="2"><button class="default float-right width-120" @click.prevent="proceed(key, total(shop))">{{$trans.translation.confirm_order}}</button></td>
				</tr>
				<tr v-show="confirmed.shop == key">
					<td colspan="4">
						<strong>{{$trans.translation.total_price}}&nbsp;:&nbsp;{{confirmed.totalPrice}}</strong>฿
						<a class="link-text padding-15-left" @click.prevent="toggleForm(key)" v-show="confirmed.discount_applied === false">{{$trans.translation.apply_discount}}</a>
						<span class="font-green bold-font" v-show="confirmed.discount">{{$trans.translation.discount}}&nbsp;{{confirmed.discount}}</span>
						<div v-show="formVisible == key && confirmed.discount_applied === false" class="input-group full-width padding-15-top">
							<input v-model="code" type="text" placeholder="CODE">
							<button :disabled="$root.loading" @click.prevent="applyDiscount(shop[0].options.shop_id)" type="button" class="form-input-btn checkmark-btn"><i class="fas fa-check"></i></button>
						</div>
					</td>
				</tr>
				<tr v-show="confirmed.shop == key">
					<td colspan="4">
						<label class="input-label">{{$trans.translation.shipping}}</label>
						<form @submit.prevent="confirmOrder(shop, key)">
						<li class="list-no-style padding-5" v-for="item, index in shop[0].options.shipping">
							<input required name="shipping" :id="index" type="radio" :value="item" v-model="confirmed.shipping">
							<label :for="index">{{ item.method }}&nbsp;{{$trans.translation.shipping_time}}&nbsp;{{item.time}}&nbsp;{{$trans.translation.days}}&nbsp;{{ item.free ? 'free' : '+' + item.fee + '฿' }}</label>
						</li>
							<label class="input-label margin-10-bottom">{{$trans.translation.address}}&nbsp;<a class="font-medium" @click.prevent="addressEdit = !addressEdit">{{ $trans.translation.address_edit }}</a></label>
							<div v-show="!addressEdit" class="padding-5">
								{{ user.name }}<br>
								{{ user.address }}<br>
								{{ $trans.translation.phone + ' ' + user.phone }}<br>
							</div>
							<div v-show="addressEdit" class="padding-10 half-width-res shadow-2">
								<div class="form-group">
									<input :required="addressEdit" class="full-width" type="text" v-model="user.name" :placeholder="$trans.translation.name">
								</div>
								<div class="form-group">
									<textarea :required="addressEdit" class="comment-input" type="text" v-model="user.address" :placeholder="$trans.translation.address"></textarea>
								</div>
								<div class="form-group">
									<input :required="addressEdit" class="full-width" type="text" v-model="user.phone" :placeholder="$trans.translation.phone">
								</div>
							</div>
						<div class="align-right padding-15-top">
							<button :disabled="$root.loading" class="green-btn border-radius-5 width-120-res" type="submit">{{$trans.translation.place_order}}</button>
						</div>
						</form>
					</td>
				</tr>
			</table>
		</div>

	  <div v-show="products.length === 0 || !Object.keys(products).length" class="panel-body align-center">
			<h2 class="font-grey">{{$trans.translation.product_none}}</h2>
		</div>

	</div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
	data() {
		return {
			formVisible: null,
			addressEdit: false,
			confirmed: {
				shop: null,
				totalPrice: null,
				discount: null,
				discount_applied: false,
				shipping: null,
			},
			code: null,
			products: [],
			loaded: false
		}
	},
	props: [
		'user',
	],
	methods: {
		total: function(shop) {
			let totalPrice = [];
			Object.entries(shop).forEach(([key, val]) => {
					var subTotal = val.price * val.qty
					totalPrice.push(subTotal)
			});
			var total = totalPrice.reduce(function(total, num){ return total + num }, 0);
			return this.$number.currency(total)
		},
		...mapActions([
			'removeFromCart',
		]),
		toggleForm(key) {
			if (this.formVisible === key){
				this.formVisible = null;
				return;
			}
			this.formVisible = key;
		},
		getCart() {
			this.$http.get(this.$root.url + '/cart/get_shop').then((response) => {
				this.loaded = true
				this.products = response.data
			});
		},
		qtyChange(item, index, shop) {
			if (item.qty > item.options.stock) {
				alert(this.$trans.translation.stock_remain + ' ' + item.options.stock)
				item.qty = item.options.stock
			} else {
				this.$http.put(this.$root.url + '/cart/update/qty', {rowId: item.rowId, qty: item.qty}).then((response)=>{
					this.products[item.options.shop_name]
				});
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
		proceed(key, total) {
			if (!confirm(this.$trans.translation.confirm_order_notice)) {
				return
			} else {
			if (this.confirmed.shop === key){
				this.confirmed.shop = null;
				this.confirmed.totalPrice = null;
				return;
			}
			this.confirmed.shop = key;
			this.confirmed.totalPrice = total;
			}
		},
		confirmOrder(shop, key) {
			if (!confirm(this.$trans.translation.confirm_order + '?')) {
				return
			} else {
				this.$Progress.start()
				this.$root.loading = true
				return this.$http.post(this.$root.url + '/order/sending', {
					products: shop,
					sender_id: this.user.id,
					sender_name: this.user.name,
					reciever_name: key,
					address: this.user.name + ' ' + this.user.address + ' (phone ' + this.user.phone + ')',
					total_price: this.confirmed.totalPrice,
					discount: this.confirmed.discount,
					shipping: this.confirmed.shipping,
				}).then(response => {
					this.$delete(this.products, key)
					this.confirmed.shop = null;
					this.confirmed.totalPrice = null;
					this.confirmed.discount = null;
					this.confirmed.discount_applied = null;
					this.confirmed.shipping = null;
					toastr.success(this.$trans.translation.success)
					this.$Progress.finish()
					this.$root.loading = false
				}, response => {
					this.$root.loading = false
					toastr.error(this.$trans.translation.error)
				});
			}
		},
		applyDiscount(id) {
			this.$root.loading = true
				this.$http.post(this.$root.url + '/profile/promotions/code/validate', {code: this.code, shop_id: id}).then(response => {
					this.$root.loading = false
					if (response.body.status === true) {
						if (response.body.type == 'percent') {
							var price = this.confirmed.totalPrice.split(',').join('')
							var calculated = price - ((response.body.discount / 100) * price).toFixed(0)
							if (calculated < 0) {
								alert(this.$trans.translation.discount_not_valid)
								this.code = null
							} else {
								this.confirmed.totalPrice = this.$number.currency(calculated)
								this.confirmed.discount = response.body.discount + '%'
								this.confirmed.discount_applied = true
								this.formVisible = null
								this.code = null
							}
						} else if (response.body.type == 'baht') {
							var price = this.confirmed.totalPrice.split(',').join('')
							var calculated = price - response.body.discount
							if (calculated < 0) {
								alert(this.$trans.translation.discount_not_valid)
								this.code = null
							} else {
								this.confirmed.totalPrice = this.$number.currency(calculated)
								this.confirmed.discount = response.body.discount + ' ฿'
								this.confirmed.discount_applied = true
								this.formVisible = null
								this.code = null
							}
						}
					} else {
						alert(this.$trans.translation.discount_not_valid)
					}
				}, response => {
					this.$root.loading = false
					toastr.error(this.$trans.translation.error);
				});
		}
	},
	mounted() {
		this.getCart();
	}
}
</script>
