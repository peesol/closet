<template>
<div class="panel-body">
  <vue-progress-bar></vue-progress-bar>
  <div class="padding-15-bottom">
    <button class="orange-btn normal-sq width-120" @click.prevent="formVisible = !formVisible">{{$trans.translation.add}}</button>
  </div>

  <transition name="slide-down-height">
    <div v-show="formVisible">
      <form class="panel-body shadow-2" v-on:submit.prevent="edit" method="post">

        <div class="form-group margin-10-bottom">
          <div class="input-group">

            <select required class="input-addon transparent-bg auto-width" name="type" v-model="type">
                <option value="facebook">Facebook</option>
                <option value="instagram">Instagram</option>
                <option value="line">Line</option>
                <option value="youtube">Youtube</option>
                <option value="phone">{{$trans.translation.phone}}</option>
                <option value="email">{{$trans.translation.email}}</option>
                <option value="website">{{$trans.translation.website}}</option>
                <option value="location">{{$trans.translation.location}}</option>
              </select>

            <input type="text" v-validate="'required'" :class="{'input-addon-field': true,'is-error': errors.has('body')}" v-model="body" name="body">
          </div>
          <span v-show="errors.has('body')" class="span-error">{{ errors.first('body') }}</span>
        </div>

        <div class="form-group">
          <label class="full-label input-label">{{$trans.translation.link}}&nbsp;<small>({{$trans.translation.optional}})</small></label>
          <div class="input-group">
            <input type="text" :class="{'input-addon-field': true,'is-error': errors.has('link')}" v-model="link" name="link" placeholder="http://www.yourlink.com">
          </div>
        </div>
        <div class="align-right padding-15-top">
          <button class="orange-btn normal-sq">{{$trans.translation.edit_submit}}</button>
        </div>
      </form>
    </div>
  </transition>

  <div v-for="(contact, index) in contacts" v-show="contacts.length" class="shadow-2 margin-20-top">

    <div class="color-heading" :class="contact.type">
      <span :class="'icon-' + contact.type"></span>
    </div>
    <div class="padding-15-horizontal padding-15-top">
      <div class="form-group">
        <div class="input-group">
          <input class="form-input-alt" type="text" v-model="contact.body">
          <button class="icon-checkmark form-input-btn" type="button" @click.prevent="updateBody(contact.id,contact.body)"></button>
        </div>
      </div>

      <div class="form-group">
        <div class="input-group">
          <input class="form-input-alt" type="text" placeholder="http://www.yourlink.com" v-model="contact.link">
          <button class="icon-checkmark form-input-btn" type="button" @click.prevent="updateLink(contact.id,contact.link)"></button>
        </div>
      </div>

      <div class="form-group margin-10-top">
        <label class="font-grey input-label">{{$trans.translation.show}}</label>
        <button class="transparent-bg" @click.prevent="toggle(contact.id, index)">
          <span :class="{ 'icon-checked font-green': contact.show == true, 'icon-unchecked font-link': contact.show == false}"></span>
        </button>
      </div>
    </div>

    <div class="align-right panel-body">
      <button @click.prevent="remove(contact.id, index)" class="delete-btn round-btn">
        <small class="icon-bin"></small>
      </button>
    </div>

  </div>

  <div v-show="!contacts.length" class="padding-15-vertical">
    <label class="full-label input-label">{{$trans.translation.no_contact}}</label>
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
    getContact() {
      this.$Progress.start();
      this.$http.get(this.$root.url + '/' + this.$route.params.shop + '/edit/contact/get').then((response) => {
        this.contacts = response.body
        this.$Progress.finish();
      });
    },
    updateBody(contactId, contactBody) {
      this.$http.put(this.$root.url + '/' + this.$route.params.shop + '/edit/contact/' + contactId, {
        body: contactBody,
      }).then((response) => {
        toastr.success(this.$trans.translation.saved);
      }, (response) => {
        toastr.error(this.$trans.translation.error);
      });
    },
    updateLink(contactId, contactLink) {
      this.$http.put(this.$root.url + '/' + this.$route.params.shop + '/edit/contact/' + contactId, {
        link: contactLink,
      }).then((response) => {
        toastr.success(this.$trans.translation.saved);
      }, (response) => {
        if (response.body.link) {
          toastr.error(response.body.link);
        } else {
          toastr.error(this.$trans.translation.error);
        }
      });
    },
    toggle(contactId, index) {
      this.$http.put(this.$root.url + '/' + this.$route.params.shop + '/edit/contact/' + contactId + '/show').then((response) => {
        if (this.contacts[index].show) {
          this.$set(this.contacts[index], 'show', false)
        } else {
          this.$set(this.contacts[index], 'show', true)
        }
        toastr.success(this.$trans.translation.saved)
      }, (response) => {
        toastr.error(this.$trans.translation.error);
      });
    },
    edit() {
      toastr.options.preventDuplicates = true;
      toastr.options.timeOut = 2000;
      this.$Progress.start();
      toastr.info(this.$trans.translation.wait);
      this.$http.post(this.$root.url + '/' + this.$route.params.shop + '/edit/contact', {
        type: this.type,
        body: this.body,
        link: this.link,
      }).then((response) => {
        this.$Progress.finish();
        toastr.success(this.$trans.translation.saved);
        this.contacts.push(response.body)
      }, (response) => {
        if (response.body.link) {
          toastr.error(response.body.link);
        } else {
          toastr.error(this.$trans.translation.error);
        }
        this.$Progress.fail();
      });
    },

    remove(contactId, index) {
      if (!confirm(this.$trans.translation.delete_confirm)) {
        return;
      }
      this.$http.delete(this.$root.url + '/' + this.$route.params.shop + '/edit/contact/' + contactId + '/delete').then((response) => {
        toastr.success(this.$trans.translation.success);
        this.contacts.splice(index, 1)
      }, (response) => {
        toastr.error(this.$trans.translation.error);
      });
    }
  },
  created() {
    this.getContact()
  }
}
</script>
