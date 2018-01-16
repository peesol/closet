<template>
	<div>
		<vue-progress-bar></vue-progress-bar>
		<table v-show="!products.length" class="c-table" v-for="shop, key in products">
			<tr>
				<td colspan="4" class="cart-shop"><span class="font-bold grey-font">{{key}}</span></td>
			</tr>
			<tr>
				<th>{{$trans.translation.product_name}}</th>
				<th>{{$trans.translation.choice}}</th>
				<th>{{$trans.translation.price}}</th>
				<th>{{$trans.translation.amount}}</th>
			</tr>
			<tr v-for="(item, index) in shop">
				<td class="overflow-hidden"><span v-show="confirmed.shop !== key" class="icon-cross remove-p-cart" @click.prevent="removeProduct(item.rowId, index, item.options.shop_name)"></span>&nbsp;{{item.name}}</td>
				<td class="m-cell">{{item.options.choice ? item.options.choice : '---'}}</td>
				<td class="s-cell">{{numeral(item.price)}}</td>
				<td class="s-cell"><input v-bind:disabled="confirmed.shop == key" type="number" min="1" max="99" @change.prevent="qtyChange(item)" v-model="item.qty"></td>
			</tr>
			<tr v-show="confirmed.shop !== key">
				<td colspan="2" class="total-price">{{$trans.translation.total_price}}&nbsp;:&nbsp;{{total(shop)}}&nbsp;&#3647;</td>
				<td colspan="2"><button class="btn float-right" @click.prevent="proceed(key, total(shop))">{{$trans.translation.confirm_order}}</button></td>
			</tr>
			<tr v-show="confirmed.shop == key">
				<td colspan="2">
					{{$trans.translation.total_price}}&nbsp;:&nbsp;{{confirmed.totalPrice}}&nbsp;&#3647;
					<a href="#" class="link-text" @click.prevent="toggleForm(key)" v-show="confirmed.discount_applied === false">{{$trans.translation.apply_discount}}</a>
					<span class="green-font bold-font">{{confirmed.discount}}</span>
				</td>
				<td colspan="2"><button class="green-btn float-right" @click.prevent="confirmOrder(shop, key)">{{$trans.translation.place_order}}</button></td>
			</tr>
			<tr v-show="formVisible == key && confirmed.discount_applied === false">
				<td colspan="4">
					<div class="input-group">
						<input v-model="code[key]" required type="text" min="1" style="width:150px; background:#f9f9f9;">
						<button @click.prevent="applyDiscount(shop[0].options.shop_id, key)" type="button" class="input-addon" style="height:30px; padding:7px; border:none;"><small class="icon-checkmark"></small></button>
					</div>
				</td>
			</tr>
		</table>

		<h4 v-show="products.length == 0">{{$trans.translation.product_none}}</h4>

	</div>
</template>

<script>
import { mapActions } from 'vuex'
import numeral from 'numeral'

export default {
	data() {
		return {
			formVisible: null,
			confirmed: {
				shop: null,
				totalPrice: null,
				discount: null,
				discount_applied: false,
			},
			code: [],
			products: [],
			trans: this.$trans,
			url: window.Closet.url,

		}
	},
	props: {
		userId: null,
		userName: null,
	},
	methods: {
		total: function(shop) {
			let totalPrice = [];
			Object.entries(shop).forEach(([key, val]) => {
					var subTotal = val.price * val.qty
					totalPrice.push(subTotal)
			});
			var total = totalPrice.reduce(function(total, num){ return total + num }, 0);
			return numeral(total).format('0,0')
		},
		numeral: function(price) {
			return numeral(price).format('0,0')
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
			this.$http.get(this.url + '/cart/get_shop').then((response) => {
				this.products = response.data
			});
		},
		qtyChange(item) {
				this.$http.put(this.url + '/cart/update/qty', {rowId: item.rowId, qty: item.qty}).then((response)=>{
					this.products[item.options.shop_name]
				});
		},
		removeProduct(id, index, shop) {
			this.removeFromCart()
			if (!confirm(this.$trans.translation.delete_confirm)) {
				return
			} else {
				return this.$http.put(this.url + '/cart/remove/' + id, {rowId: id}).then((response) => {
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
				return this.$http.post(this.url + '/order/sending', {
					products: shop,
					sender_id: this.userId,
					sender_name: this.userName,
					reciever_name: key,
					total_price: this.confirmed.totalPrice,
					discount: this.confirmed.discount,
				}).then((response) => {
					this.$delete(this.products, key)
					this.confirmed.shop = null;
					this.confirmed.totalPrice = null;
					this.confirmed.discount = null;
					this.confirmed.discount_applied = null;
					toastr.success(this.$trans.translation.success)
					this.$Progress.finish()
				});
			}
		},
		applyDiscount(id, key) {
				this.$http.post(this.url + '/profile/promotions/code/validate', {code: this.code[key], shop_id: id}).then((response)=>{
					if (response.body.status === true) {
						if (response.body.type == 'percent') {
							var price = this.confirmed.totalPrice.split(',').join('')
							var calculated = price - ((response.body.discount / 100) * price).toFixed(0)
							this.confirmed.totalPrice = numeral(calculated).format('0,0')
							this.confirmed.discount = this.$trans.translation.discount + ' ' + response.body.discount + '%'
							this.confirmed.discount_applied = true
						} else if (response.body.type == 'baht') {
							var price = this.confirmed.totalPrice.split(',').join('')
							var calculated = price - response.body.discount
							this.confirmed.totalPrice = numeral(calculated).format('0,0')
							this.confirmed.discount = this.$trans.translation.discount + ' ' + response.body.discount + this.$trans.translation.baht
							this.confirmed.discount_applied = true
						}
					} else {
						alert(this.$trans.translation.discount_not_valid)
					}
				});
		}
	},
	mounted() {
		this.getCart();
	}
}
</script>
