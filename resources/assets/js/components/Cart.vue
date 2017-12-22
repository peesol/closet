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
				<td class="overflow-hidden"><span class="icon-cross remove-p-cart" @click.prevent="removeProduct(item.rowId, index, item.options.shop_name)"></span>&nbsp;{{item.name}}</td>
				<td class="m-cell">{{item.options.choice ? item.options.choice : '---'}}</td>
				<td class="s-cell">{{numeral(item.price)}}</td>
				<td class="s-cell"><input type="number" min="1" max="99" @change.prevent="qtyChange(item.rowId, item.qty)" v-model="item.qty"></td>
			</tr>
			<tr>
				<td colspan="2" class="total-price">{{$trans.translation.total_price}}&nbsp;:&nbsp;{{total(shop)}}&nbsp;<span style="font-weight: 400;">&#3647;</span></td>
				<td colspan="2"><button class="btn float-right" @click.prevent="confirmOrder(shop, key, total(shop))">{{$trans.translation.confirm_order}}</button></td>
			</tr>
			<tr>
			</tr>
		</table>
		<h4 v-show="products.length == 0">{{$trans.translation.product_none}}</h4>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import numeral from 'numeral'

export default {
	data() {
		return {
			products: [],
			trans: this.$trans,
			url: window.Closet.url,
			total: function(shop){
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
			}
		}
	},
	props: {
		userId: null,
		userName: null,
	},
	methods: {
		getCart() {
			this.$http.get(this.url + '/cart/get_shop').then((response) => {
				this.products = response.data
			});
		},
		qtyChange(id, qty) {
				this.$http.put(this.url + '/cart/update/qty', {rowId: id, qty: qty});
		},
		removeProduct(id, index, shop) {
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
		confirmOrder(shop, key, total) {
			if (!confirm(this.$trans.translation.confirm_order)) {
				return
			} else {
				this.$Progress.start()
				return this.$http.post(this.url + '/order/sending', {
					products: shop,
					sender_id: this.userId,
					sender_name: this.userName,
					reciever_name: key,
					total_price: total,
				}).then((response) => {
					this.$delete(this.products, key);
					toastr.success(this.$trans.translation.success)
					this.$Progress.finish()
				});
			}
		}
	},
	mounted() {
		this.getCart();
	}
}
</script>
