<template>
  <div class="pagination">
    <div class="first" :class="{'transparent-el' : meta[0].current_page < 1}" v-show="meta[0].total_pages > 1">
      <a @click.prevent="switched(1)" v-show="meta[0].current_page > 1">
        &laquo;&nbsp;{{ $trans.translation.first_page }}
      </a>
    </div>

    <div class="pages">

      <div class="arrow" :class="{'transparent-el' : meta[0].current_page === 1}">
        <a v-show="meta[0].current_page > 1" @click.prevent="switched(meta[0].current_page - 1)">
            &laquo;
        </a>
      </div>

      <div class="page" v-for="page in meta[0].total_pages" :class="{'active' : meta[0].current_page == page}" v-show="Math.abs(page - meta[0].current_page - 1) < 3">
        <a @click.prevent="switched(page)">
          <span>{{ page }}</span>
        </a>
      </div>

      <div class="arrow" :class="{'transparent-el' : meta[0].current_page === meta[0].total_pages}">
        <a v-show="meta[0].current_page < meta[0].total_pages" @click.prevent="switched(meta[0].current_page + 1)">
          &raquo;
        </a>
      </div>

    </div>

    <div class="last" :class="{'transparent-el' : meta[0].current_page === meta[0].total_pages}">
      <a v-show="meta[0].current_page < meta[0].total_pages" @click.prevent="switched(meta[0].total_pages)">
        {{ $trans.translation.last_page }}&nbsp;&raquo;
      </a>
    </div>

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
        this.$emit('switched', page)
    },

    pageIsOutOfBounds(page) {
      return page < 0 || page > this.meta[0].total_pages
    }
  }
}
</script>
