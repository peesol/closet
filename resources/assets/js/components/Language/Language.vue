<template>
<div style="padding:5px; height:150px;">
    <select class="lang-input" :name="selectedLang" v-model="selectedLang" @change="selectLang(selectedLang)">
        <option v-for="(lang, key) in langs" :value="key">{{lang}}</option>
    </select>
</div>
</template>

<script>
import thai from 'vee-validate/dist/locale/th';
const dictionary = {
  th: {
    messages: thai.messages,
    attributes: {
      product_name: 'ชื่อสินค้า',
      name: 'ชื่อ',
      phone: 'เบอร์โทรศัพท์',
      address: 'ที่อยู่',
      price: 'ราคา',
      description: 'รายละเอียด',
      body: 'ข้อมูล',
      account_number: 'เลขที่บัญชี',
      account_name: 'ชื่อบัญชี',
      amount: 'จำนวน',
    }
  },
  en: {
    messages: {
      required: 'This field is required.'
    },
    attributes: {
      account_number: 'account number',
      account_name: 'account name',
    }
  }
};

	export default {
		data() {
			return {
        selectedLang: this.$root.locale,
				langs: {
          th: 'ภาษาไทย',
          en: 'English',
        },
			}
		},
		methods: {
      selectLang(lang) {
        this.$http.put(this.$root.url + '/locale_ajax/' + lang)
          .then((response) => {
            document.location.href= window.location.href;
          });
      },
		},

		created() {
			 this.$trans.translate(this.$root.locale)
       this.$validator.localize(dictionary)
       this.$validator.localize(this.$root.locale)
		}
	}
</script>
