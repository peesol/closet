<template>
<div v-show="meta[0].total_pages > 1">
  <ul class="pagination">
    <li v-show="meta[0].current_page > 0">
      <a href="#" @click.prevent="switched(meta[0].current_page - 1)">
        &laquo;
      </a>
    </li>
    <li v-for="page in meta[0].total_pages">
      <a href="#" :class="{'active' : meta[0].current_page == page - 1}" @click.prevent="switched(page - 1)">{{ page }}</a>
    </li>
    <li v-show="meta[0].current_page < meta[0].total_pages - 1">
      <a href="#" @click.prevent="switched(meta[0].current_page + 1)">
        &raquo;
      </a>
    </li>
  </ul>
</div>
</template>

<script>
export default {
  props: [
    'meta'
  ],
  methods: {
    switched(page, query = this.$route.query) {
      if (this.pageIsOutOfBounds(page)) {
        return alert('out of bound');
      }
        this.$router.replace({
          query: Object.assign({}, this.$route.query, {page})
        })
    },

    pageIsOutOfBounds(page) {
      return page < 0 || page > this.meta[0].total_pages
    }
  }
}
</script>
