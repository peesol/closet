<template>
<div class="panel-body">
  <form class="input-group" @submit.prevent="search(keyword)">
    <input type="text" class="input-addon-field" id="search-bar" v-model="keyword">
    <button class="input-addon" type="submit" name="button">Search</button>
  </form>

</div>
</template>

<script>
import autocomplete from 'autocomplete.js'
import algolia from 'algoliasearch'
export default {
  data() {
    return {
      keyword: null
    }
  },
  methods: {
    search(keyword) {
      document.location.href='/search/result?p=' +keyword
    }
  },
  mounted() {
    const index = algolia('40LVMO82Y8', '38f8129c58ab41b8f1a255267024a454').initIndex('products')

    autocomplete('#search-bar', {}, {
      source: autocomplete.sources.hits(index, { hitsPerPage:  10 }),
      templates: {
        suggestion(suggestion) {
          console.log(suggestion);
          return '<span>' + suggestion._highlightResult.name.value + '</span>'
        }
      }
    })
  },
}
</script>
