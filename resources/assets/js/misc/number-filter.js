export default {
  install: (Vue) => {
    Vue.prototype.$number= {
      currency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
    };
  }
};
