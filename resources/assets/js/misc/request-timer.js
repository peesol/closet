export default {
  install: (Vue) => {
    Vue.prototype.$requestTimer = function(time) {
      setInterval(() => {
        this.$root.loading = false
      }, time)
    }
  }
};
