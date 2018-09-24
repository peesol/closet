<template>
<div>
  <table class="c-table">
    <tr v-for="contact in contacts">
      <td class="center s-cell no-border"><i class="contact-btn" :class="contact.type + ' ' + contactType(contact.type)"></i></td>
      <td class="no-border">
        <a v-show="contact.link !== null" class="link-text font-bold arial" :href="contact.link">{{ contact.body }}</a>
        <label v-show="contact.link == null" class="font-grey font-light arial">{{contact.body}}</label>
      </td>
    </tr>
  </table>
</div>
</template>

<script>
export default {
  props: ['contacts'],
  methods: {
    contactType(type){
      var social = ['facebook', 'instagram', 'line', 'youtube']
      var general = {
        phone: 'phone',
        email: 'envelope',
        location: 'map-marker-alt',
        website: 'globe-americas',
      }
      if (social.includes(type)) {
        return 'fab fa-' + type
      } else if (general.hasOwnProperty(type)) {
        return 'fas fa-' + general[type];
      }
    },
  }
}
</script>
