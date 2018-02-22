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
        <li v-for="category in categories"><a @click.prevent="getSub(category)" v-bind:class="{'filter-active': category.id == $route.query.c }">{{ category.name }}</a></li>
      </ul>

      <ul v-show="$route.query.c" class="">
        <li v-for="subcategory in subcategories"><a @click.prevent="getType(subcategory)" v-bind:class="{'filter-active': subcategory.id == $route.query.sub }">{{ subcategory.name }}</a></li>
      </ul>

      <ul v-show="$route.query.sub" class="">
        <li v-for="type in types"><a @click.prevent="query(type.id)" :class="{'filter-active': type.id == $route.query.type }">{{ type.name }}</a></li>
      </ul>
      {{categories.subcategory}}
      <div class="price-filter">
          <label class="col-label">{{ $trans.translation.price}}</label>
          <input type="number" min="0" max="9999999" v-model="min" autocomplete="off" placeholder="">&nbsp;-&nbsp;
          <input type="number" min="0" max="9999999" v-model="max" autocomplete="off" placeholder="">
          <button @click.prevent="queryPrice()"><small class="icon-next-arrow"></small></button>
      </div>
      <button type="button" @click.prevent="getProduct">SEARCH</button>
  </div>


</div>

</template>

<script>
import algolia from 'algoliasearch'
import {mapGetters} from 'vuex'
import {categories} from '../category/getter'
export default {
    data() {
      return {
        categories : categories({locale: this.$root.locale}),
        subcategories : [],
        types : [],
        products : [],
        min : this.$route.query.min,
        max : this.$route.query.max,
        formVisible: false,
        current_url: window.location.href,
      }
    },
    computed: {
      selectCategory: function () {
        if (this.$route.query.c) {
          return this.categories[this.$route.query.c - 1].subcategory
        }
      },
      selectSubcategory: function () {
        if (this.$route.query.sub) {
          return this.categories[this.$route.query.c - 1].subcategory[this.$route.query.sub]
        }
      }
    },
    methods: {
      getSub(category) {
        this.subcategories = category.subcategory
        this.$router.push({ query: {
                	p : this.$route.query.p,
                	c : category.id
                }
              });
      },
     getType(subcategory) {
      this.types = subcategory.type
      this.$router.push({ query: {
                p : this.$route.query.p,
                c : this.$route.query.c,
                sub : subcategory.id
              }
            });
        },
      query(typeId) {
        this.$router.push({ query: {
                  p : this.$route.query.p,
                  c : this.$route.query.c,
                  sub : this.$route.query.sub,
                  type : typeId,
                }
              });
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
      },
      getProduct() {
        this.$router.go(this.$route.fullPath);
      }
    }
}
</script>
