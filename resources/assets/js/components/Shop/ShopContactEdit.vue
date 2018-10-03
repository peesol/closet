<template>
<div class="panel-body">
  <vue-progress-bar></vue-progress-bar>
  <div class="padding-15-bottom">
    <button class="orange-btn normal-sq width-120" @click.prevent="formVisible = !formVisible">{{$trans.translation.add}}</button>
  </div>

  <transition name="slide-down-height">
    <div v-show="formVisible">
      <form class="panel-body shadow-2" @submit.prevent="create" method="post">

        <div class="form-group margin-10-bottom">
          <div class="input-group">

            <select required class="input-addon left transparent-bg auto-width" name="type" v-model="type">
                <option value="facebook">Facebook</option>
                <option value="instagram">Instagram</option>
                <option value="line">Line</option>
                <option value="youtube">Youtube</option>
                <option value="phone">{{$trans.translation.phone}}</option>
                <option value="email">{{$trans.translation.email}}</option>
                <option value="website">{{$trans.translation.website}}</option>
                <option value="location">{{$trans.translation.location}}</option>
              </select>

            <input type="text" v-validate="'required'" class="input-addon-field right" :class="{'is-error': errors.has('body')}" v-model="body" name="body">
          </div>
          <span v-show="errors.has('body')" class="span-error">{{ errors.first('body') }}</span>
        </div>

        <div class="form-group">
          <label class="full-label input-label">{{$trans.translation.link}}&nbsp;<small>({{$trans.translation.optional}})</small></label>
          <div class="input-group">
            <input data-vv-as="*" v-validate="'url:require_protocol'" type="text" class="form-input" :class="{'is-error': errors.has('link')}" v-model="link" name="link" placeholder="http://www.example.com">
          </div>
          <span v-show="errors.has('link')" class="span-error">{{ errors.first('link') }}</span>
        </div>
        <div class="align-right padding-15-top">
          <button :disabled="$root.loading || errors.any()" type="submit" class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
        </div>
      </form>
    </div>
  </transition>

  <div v-for="(contact, index) in contacts" v-show="contacts.length" class="shadow-2 margin-20-top">

    <div class="color-heading" :class="contact.type">
      <i :class="contactType(contact.type)"></i>
    </div>
    <div class="padding-15-horizontal padding-15-top">
      <div class="form-group">
        <form class="input-group" @submit="updateBody(contact.id,contact.body)">
          <input required class="form-input-alt" type="text" v-model="contact.body">
          <button :disabled="$root.loading" class="fas fa-check form-input-btn" type="submit"></button>
        </form>
      </div>

      <div class="form-group">
        <div class="input-group">
          <input data-vv-as="*" v-validate="'url:require_protocol'" :name="'link' + index" class="form-input-alt" type="text" placeholder="http://www.yourlink.com" v-model="contact.link">
          <button :disabled="$root.loading || errors.any()" class="fas fa-check form-input-btn" type="button" @click.prevent="updateLink(contact.id,contact.link)"></button>
        </div>
        <span v-show="errors.has('link' + index)" class="span-error">{{ errors.first('link' + index) }}</span>
      </div>

      <div class="form-group margin-10-top">
        <label class="font-grey input-label margin-10-right">{{$trans.translation.show}}</label>
        <label class="switch near-text">
          <input @change.prevent="toggle(contact.id, index)" type="checkbox" :checked="contact.show">
          <span class="slider"></span>
        </label>
      </div>
    </div>

    <div class="align-right panel-body">
      <button @click.prevent="remove(contact.id, index)" class="flat-btn delete font-15em">
        <i class="fas fa-trash-alt"></i>
      </button>
    </div>

  </div>

  <div v-show="!contacts.length" class="padding-15-vertical align-center">
    <h2 class="font-grey">{{$trans.translation.no_contact}}</h2>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      contacts: [],
      type: null,
      body: null,
      link: null,
      formVisible: false,
    }
  },
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
    getContact() {
      this.$Progress.start();
      this.$root.loading = true
      this.$http.get(this.$root.url + '/manage/contact/get').then(response => {
        this.contacts = response.body
        this.$Progress.finish();
        this.$root.loading = false
      });
    },
    updateBody(contactId, contactBody) {
      this.$root.loading = true
      this.$http.put(this.$root.url + '/manage/contact/' + contactId, {
        body: contactBody,
      }).then(response => {
        this.$requestTimer(3000)
        toastr.success(this.$trans.translation.saved);
      }, response => {
        this.$requestTimer(1000)
        toastr.error(this.$trans.translation.error);
      });
    },
    updateLink(contactId, contactLink) {
      this.$root.loading = true
      this.$http.put(this.$root.url + '/manage/contact/' + contactId, {
        link: contactLink,
      }).then(response => {
        this.$requestTimer(3000)
        toastr.success(this.$trans.translation.saved);
      }, response => {
        toastr.error(this.$trans.translation.error);
        this.$requestTimer(1000)
      });
    },
    toggle(contactId, index) {
      this.$http.put(this.$root.url + '/manage/contact/' + contactId + '/show').then(response => {
        if (this.contacts[index].show) {
          this.$set(this.contacts[index], 'show', false)
        } else {
          this.$set(this.contacts[index], 'show', true)
        }
        toastr.success(this.$trans.translation.saved)
      }, response => {
        toastr.error(this.$trans.translation.error);
      });
    },
    create() {
      toastr.options.preventDuplicates = true;
      toastr.options.timeOut = 2000;
      this.$Progress.start();
      this.$root.loading = true
      toastr.info(this.$trans.translation.wait);
      this.$http.post(this.$root.url + '/manage/contact/create', {
        type: this.type,
        body: this.body,
        link: this.link,
      }).then(response => {
        this.$Progress.finish();
        this.$root.loading = false
        toastr.success(this.$trans.translation.saved);
        this.contacts.push(response.body)
        this.body = null
        this.link = null
      }, response => {
        toastr.error(this.$trans.translation.error);
        this.$Progress.fail();
        this.$root.loading = false
      });
    },

    remove(contactId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url + '/manage/contact/' + contactId + '/delete').then(response => {
        toastr.success(this.$trans.translation.success);
        this.contacts.splice(index, 1)
      }, response => {
        toastr.error(this.$trans.translation.error);
      });
    }
  },
  created() {
    this.getContact()
  }
}
</script>
