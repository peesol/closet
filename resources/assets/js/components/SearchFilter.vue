<template>
<div>
  <div class="filter-bar">
    <button class="filter-btn" @click.prevent="formVisible = !formVisible">{{ $trans.translation.choice}}&nbsp;<small class="icon-arrows-down"></small></button>
  </div>
    <div id="full-line"></div>
    <ul class="breadcrumb">
      <li v-show="">{{ }}</li>
    </ul>
  <div v-show="formVisible" class="filter-option" id="cat-option">
      <ul class="">
        <li v-for="category in cats" ><a @click.prevent="getSub(category.id)" v-bind:class="{'filter-active': category.id == c }">{{ category.name }}</a></li>
      </ul>

      <ul v-show="subcats.length > 0" class="">
        <li v-for="subcategory in subcats"><a @click.prevent="getType(subcategory.id)" v-bind:class="{'filter-active': subcategory.id == sub }">{{ subcategory.name }}</a></li>
      </ul>
      
      <ul v-show="types.length > 0" class="">
        <li v-for="type in types"><a @click.prevent="query(type.id)" :class="{'filter-active': type.id == typez }">{{ type.name }}</a></li>
      </ul>

      <div class="price-filter">
          <label class="col-label">{{ $trans.translation.price}}</label>
          <input type="number" min="0" max="9999999" v-model="min" autocomplete="off" placeholder="">&nbsp;-&nbsp;
          <input type="number" min="0" max="9999999" v-model="max" autocomplete="off" placeholder="">
          <button @click.prevent="queryPrice()"><small class="icon-next-arrow"></small></button>
      </div>
  </div>


</div>

</template>

<script>
export default {
    data() {
      return {
        cats : [],
        subcats : [],
        types : [],
        products : [],
        min : this.$route.query.min,
        max : this.$route.query.max,
        c : this.$route.query.c,
        sub : this.$route.query.sub,
        typez : this.$route.query.type,
        formVisible: false,
        url: window.Closet.url,
        current_url: window.location.href,
        
      }
    },
    props: {

    },
    methods: {
      getCategory() {
        this.$http.get(this.url + '/category_ajax/get_category').then((response)=> {this.cats = response.body; });
        if(this.$route.query.c) {
          this.$http.get(this.url + '/category_ajax/get_subcategory/' + this.$route.query.c).then((response)=> {this.subcats = response.body; });
        }

        if(this.$route.query.sub) {
          this.$http.get(this.url + '/category_ajax/get_type/' + this.$route.query.sub).then((response)=> {this.types = response.body; });
        }

      },

      getSub(categoryId) {
        this.$router.push({ query: {
                	p : this.$route.query.p,
                	c : categoryId
                }
              });
        this.getProduct();
      },

     getType(subcategoryId) {
      this.$router.push({ query: {
                p : this.$route.query.p,
                c : this.$route.query.c,
                sub : subcategoryId
              }
            });
          this.getProduct();
        },
      query(typeId) {
        this.$router.push({ query: {
                  p : this.$route.query.p,
                  c : this.$route.query.c,
                  sub : this.$route.query.sub,
                  type : typeId,
                }
              });
        this.getProduct();
      },

      queryPrice() {
        this.$router.push({ query: {
                  p : this.$route.query.p,
                  c : this.$route.query.c,
                  sub : this.$route.query.sub,
                  type : this.$route.query.type,
                  min : this.min,
                  max : this.max,
                }
              });
              this.getProduct();
      },

      getProduct() {
        //this.$http.get(this.$route.fullPath).then((response)=> {this.products = response.body; });
        this.$router.go(this.$route.fullPath);
      }
    },


    created() {
      this.getCategory();
    }
}
</script>
