<template>
<div class="relative">
  <vue-progress-bar></vue-progress-bar>
  <load-overlay bg="white-bg" :show="!loaded"></load-overlay>
  <div id="full-line" class="padding-10 full-width lightgrey-bg">
    <a class="flat-btn" :class="{'font-orange font-15em' : tab === 1}" @click="toggleTab(1)">{{$trans.translation.wait_transaction}}&nbsp;
      <span class="number font-medium" :class="{'not-empty' : added.ordered > 0}">{{ added.ordered }}</span>
    </a>
  </div>
  <div id="full-line" v-for="(item, index) in orders" class="col-2-flex-res padding-5" v-show="tab === 1 && !item.trans">
    <div class="text-row">
      <a class="link-text" @click.prevent="redirect(item.uid)">{{item.title}}</a>
    </div>
    <div class="text-row align-right-res">
      {{item.created_at}}
    </div>
  </div>
  <div id="full-line" class="padding-10 full-width lightgrey-bg">
    <a class="flat-btn" @click="toggleTab(2)" :class="{'font-orange font-15em' : tab === 2}">{{$trans.translation.transacted}}&nbsp;
      <span class="number font-medium" :class="{'not-empty' : added.trans > 0}">{{ added.trans }}</span>
    </a>
  </div>
  <div id="full-line" v-for="(item, index) in orders" class="col-2-flex-res padding-5" v-show="tab === 2 && item.trans && !item.shipped">
    <div class="text-row">
      <a class="link-text" @click.prevent="redirect(item.uid)">{{item.title}}</a>
    </div>
    <div class="text-row align-right-res">
      {{item.created_at}}
    </div>
  </div>
  <div id="full-line" class="padding-10 full-width lightgrey-bg">
    <a class="flat-btn" @click="toggleTab(3)" :class="{'font-orange font-15em' : tab === 3}">{{$trans.translation.shipped}}&nbsp;
      <span class="number font-medium" :class="{'not-empty' : added.shipped > 0}">{{ added.shipped }}</span>
    </a>
  </div>
  <div id="full-line" v-for="(item, index) in orders" class="col-2-flex-res padding-5" v-show="tab === 3 && item.shipped">
    <div class="text-row">
      <a class="link-text" @click.prevent="redirect(item.uid)">{{item.title}}</a>
    </div>
    <div class="text-row align-right-res">
      {{item.created_at}}
    </div>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      orders: [],
      loaded: false,
      tab: null
    }
  },
  computed: {
    added: function () {
      var ordered = 0;
      var trans = 0;
      var shipped = 0;
      this.orders.forEach(function (item) {
        if(item.trans) { trans++; }
        if(!item.trans) { ordered++; }
        if(item.shipped) { shipped++; }
      });
      return { trans, ordered, shipped};
    }
  },
  methods: {
    getMessages() {
      this.$Progress.start()
      this.$http.get(this.$root.url + '/order/buying/get').then(response => {
        this.orders = response.body.data;
        this.$Progress.finish()
        this.loaded = true
      });
    },
    toggleTab(id) {
      if (this.tab === id) {
        this.tab = null;
        return;
      }
      this.tab = id;
    },
    redirect(order) {
      document.location.href = this.$root.url + '/order/' + order;
    }
  },
  created() {
    this.getMessages();
  },
}
</script>
