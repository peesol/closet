<template>
<div class="panel-body">
  <div class="padding-10">
    <button class="orange-btn normal-sq width-120" @click.prevent="formVisible = !formVisible">{{ $trans.translation.choice}}&nbsp;<small class="fas fa-chevron-down"></small></button>
  </div>

  <div v-show="formVisible" class="filter">
    <div class="categories flex flex-start-res">
      <ul>
        <li v-for="category in categories">
          <font @click.prevent="selectCategory(category)" v-bind:class="{'filter-active': category.id == selected.c }">{{ category.name }}</font>
        </li>
      </ul>

      <ul v-show="selected.c">
        <li v-for="subcategory in subcategories">
          <font @click.prevent="selectSubcategory(subcategory)" v-bind:class="{'filter-active': subcategory.id == selected.sub }">{{ subcategory.name }}</font>
        </li>
      </ul>

      <ul v-show="selected.sub && types.length">
        <li v-for="type in types">
          <font @click.prevent="selectType(type)" :class="{'filter-active': type.id == selected.type }">{{ type.name }}</font>
        </li>
      </ul>
    </div>

      {{categories.subcategory}}
      <div class="price">
          <label class="padding-15-right input-label">{{ $trans.translation.price}}</label>
          <input type="number" min="0" max="9999999" v-model="min" autocomplete="off" :placeholder="$trans.translation.min">&nbsp;-&nbsp;
          <input type="number" min="0" max="9999999" v-model="max" autocomplete="off" :placeholder="$trans.translation.max">
      </div>
      <div class="breadcrumb margin-20-top half-width-res" v-show="selected.c || min || max">
        <p class="font-bold no-margin">{{ $trans.translation.search_query}}&nbsp;
          <font class="font-green">{{ $route.query.p }}</font>
          &nbsp;{{ $trans.translation.in}}</p>
        <i class="font-bold" v-show="selected.c">{{ $trans.translation.category }}</i>
        <span>{{ breadcrumb.category }}</span>
        <span>{{ breadcrumb.subcategory }}</span>
        <span>{{ breadcrumb.type }}</span><br>
        <span v-show="min">{{ $trans.translation.price }}{{ $trans.translation.min }}&nbsp;{{ min }}</span>
        <span v-show="max">{{ $trans.translation.price }}{{ $trans.translation.max }}&nbsp;{{ max }}</span>
        <div class="full-width align-right padding-15-top">
          <button class="normal-sq orange-btn width-120" type="button" @click.prevent="applyFilter">{{ $trans.translation.search}}</button>
        </div>
      </div>

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
