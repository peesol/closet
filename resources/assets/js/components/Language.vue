<template>
<div style="padding:5px; height:150px;">
    <select class="lang-input" :name="lang" v-model="lang" @change="selectLang(lang)">
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
    }
  },
  en: {
    attributes: {
      account_number: 'account number',
      account_name: 'account name',
    }
  }
};

	export default {
		data() {
			return {
				langs: [],
				lang: this.language,
				url: window.Closet.url,
				current_url: window.location.href
			}
		},

		props: {
			language: null
		},
		methods: {
            getLang() {
                    this.$http.get(this.url + '/locale_ajax')
                    .then((response) => {return response.json()
                        .then((json) => {
                          this.langs = json.locale;
                          this.$trans.translate(json.current_locale);
                        });
                    });
                },

            selectLang() {
                    this.$http.put(this.url + '/locale_ajax/' + this.lang)
                    .then((response) => {return response.json()
                        .then((json) => {document.location.href= this.current_url;});
                    });
                },
			},

		created() {
			 this.getLang();
       this.$validator.localize(this.language, dictionary.th)
		}
	}
</script>
