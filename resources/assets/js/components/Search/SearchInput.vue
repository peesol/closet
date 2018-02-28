<template>
<div class="search-form">
  <form @submit.prevent="search(keyword)">
    <input type="text" class="search-input" id="search-bar" v-model="keyword">
    <button class="search-btn icon-search" type="submit"></button>
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
    const index = algolia('40LVMO82Y8', 'b1bd2a6d3bfdb0f70c02b69e9eb00472').initIndex('products')

    autocomplete('.search-input', {}, {
      source: autocomplete.sources.hits(index, { hitsPerPage:  10 }),
      templates: {
        suggestion(suggestion) {
          return suggestion._highlightResult.name.value
        }
      }
    }).on('autocomplete:selected', function(event, suggestion, dataset) {
      console.log(suggestion);
      document.location.href='/search/result?p=' + suggestion.name
    });
  },
}
</script>
