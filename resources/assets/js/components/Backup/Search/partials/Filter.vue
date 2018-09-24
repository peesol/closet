<template>
<div>
  <div class="filter-bar" id="full-line">
    <button class="filter-btn" @click.prevent="formVisible = !formVisible">{{ $trans.translation.choice}}&nbsp;<i class="fas fa-caret-down"></i></button>
  </div>
    <ul class="breadcrumb">
      <p>{{ breadcrumb.category }}</p>
      <p>{{ breadcrumb.subcategory }}</p>
      <p>{{ breadcrumb.type }}</p>
      <p>{{ selected.min }} - {{ selected.max }}</p>
    </ul>
  <div v-show="formVisible" class="filter-option">
      <ul class="">
        <li v-for="category in categories"><a @click.prevent="selectCategory(category)" v-bind:class="{'filter-active': category.id == selected.c }">{{ category.name }}</a></li>
      </ul>

      <ul v-show="selected.c">
        <li v-for="subcategory in subcategories"><a @click.prevent="selectSubcategory(subcategory)" v-bind:class="{'filter-active': subcategory.id == selected.sub }">{{ subcategory.name }}</a></li>
      </ul>

      <ul v-show="selected.sub">
        <li v-for="type in types"><a @click.prevent="selectType(type)" :class="{'filter-active': type.id == selected.type }">{{ type.name }}</a></li>
      </ul>
      {{categories.subcategory}}
      <div class="price-filter">
          <label class="col-label">{{ $trans.translation.price}}</label>
          <input type="number" min="0" max="9999999" v-model="min" autocomplete="off" placeholder="">&nbsp;-&nbsp;
          <input type="number" min="0" max="9999999" v-model="max" autocomplete="off" placeholder="">
          <button @click.prevent="priceFilter()"><small class="icon-next-arrow"></small></button>
      </div>
      <button type="button" @click.prevent="applyFilter">SEARCH</button>
  </div>


</div>

</template>

<script>
import {categories} from '../../../category/getter'
export default {
    data() {
      return {
        categories : categories({locale: this.$root.locale}),
        subcategories: [],
        types : [],
        products : [],
        min : null,
        max : null,
        formVisible: false,
        breadcrumb: {},
        selected: {},
      }
    },
    methods: {
      applyFilter() {
        if (this.min >= 0 || this.max > 0) {
          this.selected = Object.assign({}, this.selected, {
            min: this.min,
            max: this.max
          })
        }
        this.$router.push({
          query: {
            p: this.$route.query.p,
            ...this.selected
          }
        })
      },
      selectCategory(category) {
        this.subcategories = category.subcategory
        this.breadcrumb = Object.assign({}, this.breadcrumb, {
          category: category.name,
          subcategory: null,
          type: null
        })
        this.selected = Object.assign({}, this.selected, {
          c: category.id,
          sub: null,
          type: null
        })
      },
      selectSubcategory(subcategory) {
        this.types = subcategory.type,
        this.breadcrumb = Object.assign({}, this.breadcrumb, {
          subcategory: subcategory.name,
          type: null
        })
        this.selected = Object.assign({}, this.selected, {
          sub: subcategory.id,
          type: null
        })
      },
      selectType(type) {
        this.breadcrumb = Object.assign({}, this.breadcrumb, {
          type: type.name
        })
        this.selected = Object.assign({}, this.selected, {type: type.id})
      },
    }
}
</script>
