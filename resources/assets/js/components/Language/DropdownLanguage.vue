<template>
<div id="full-line">
  <li class="nested" v-for="(lang, key) in langs" @click.prevent="selectLang(key)">{{lang}}&nbsp;<small v-show="key == $root.locale" class="icon-checkmark font-green"></small></li>
</div>
</template>

<script>
	export default {
		data() {
			return {
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
	}
</script>
