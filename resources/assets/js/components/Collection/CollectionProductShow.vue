<template>
<div>
    <div class="panel-heading"><h4 class="no-margin">{{$trans.translation.products}}</h4></div>
        <div v-if="products.length" class="panel-body thumbnail-grid">
            <div v-for="product in products" class="products-wrap">
                <a :href="url + '/product/'+ product.uid"><img class="products-img-thumb" :src="product.thumbnail"></a>
                <div>
                <h4 class="no-margin"><a class="link-text" :href="url + '/product/'+ product.uid" style="font-size:1.2em;">{{product.name}}</a></h4>
                <p class="no-margin">{{$trans.translation.price}}&nbsp:&nbsp{{product.price}}</p>
                <p class="no-margin">{{$trans.translation.category}}&nbsp:&nbsp{{product.category}}</p>
                <p class="no-margin">{{$trans.translation.by}}&nbsp<a class="link-text" :href="url + '/'+ product.slug">{{product.shop}}</a></p>
                </div>
            </div>
        </div>
        <div v-else class="panel-body">
            <p>{{$trans.translation.col_product_none}}</p>
        </div>
</div>
</template>

<script>

export default {
    data() {
        return {
            products: [],
            url: window.Closet.url,
        }
    },
    props: {
        colId: null,
    },

    methods: {
            getProduct() {
                    this.$http.get(this.$root.url + '/collection_ajax/products/' + this.colId).then((response) => { this.products = response.body.data; });
            },
    },

    created() {
        this.getProduct();
    },
}
</script>
