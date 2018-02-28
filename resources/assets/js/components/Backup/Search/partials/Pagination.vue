<template>
<div v-show="meta.total >= 21">
  <ul class="pagination">
    <li :class="{'disabled' : meta.current_page === 1}">
      <a href="#" @click.prevent="switched(meta.current_page - 1)">
        &laquo;
      </a>
    </li>
    <li :class="{'active' : meta.current_page === $route.query.page}" v-for="page in meta.last_page">
      <a href="#" @click.prevent="switched(page)">{{ page }}</a>
    </li>
    <li :class="{'disabled' : meta.current_page === meta.last_page}">
      <a href="#" @click.prevent="switched(meta.current_page + 1)">
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
        return ;
      }
        this.$router.replace({
          query: Object.assign({}, this.$route.query, {page})
        })
    },

    pageIsOutOfBounds(page) {
      return page < 1 || page > this.meta.last_page
    }
  }
}
</script>
