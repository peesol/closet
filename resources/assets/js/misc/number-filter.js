export default {
  install: (Vue) => {
    Vue.prototype.$number= {
      currency(amount) {
        if (amount) {
          return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
      }
    };
  }
};
