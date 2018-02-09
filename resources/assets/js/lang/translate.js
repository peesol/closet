import english from './en'
import thai from './th'

export default {
  install: (Vue) => {
    Vue.prototype.$trans = {
      translation: [],
      translate(lang) {
        if(lang === 'en') {
          this.translation = english;
        } else if (lang === 'th') {
          this.translation = thai;
        }
      }
    };
  }
};
