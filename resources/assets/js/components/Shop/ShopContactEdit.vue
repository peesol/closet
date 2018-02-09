<template>
<div>
<vue-progress-bar></vue-progress-bar>
                    <button class="add-col-btn" @click.prevent="formVisible = !formVisible" >{{$trans.translation.add}}</button>
                    <transition name="slide-down-height">
                    <div style="padding: 20px;" v-show="formVisible">
                        <form v-on:submit.prevent="edit" method="post">
                        <div style="padding:0;">
                            <div class="form-group">
                                 <div class="input-group" style="margin-bottom:8px;">
                                     <span class="input-addon" style="padding: 0;">
                                       <select required class="select-input" name="type" v-model="type">
                                          <option value="facebook">Facebook</option>
                                          <option value="instagram">Instagram</option>
                                          <option value="line">Line</option>
                                          <option value="youtube">Youtube</option>
                                          <option value="phone">{{$trans.translation.phone}}</option>
                                          <option value="email">{{$trans.translation.email}}</option>
                                          <option value="website">{{$trans.translation.website}}</option>
                                          <option value="location">{{$trans.translation.location}}</option>
                                        </select>
                                      </span>
                                     <input type="text" v-validate="'required'" :class="{'input-addon-field': true,'is-error': errors.has('body')}" v-model="body" name="body">
                                 </div>
                                 <span v-show="errors.has('body')" class="span-error">{{ errors.first('body') }}</span>
                            </div>

                            <div class="form-group">
                              <label class="full-label">{{$trans.translation.link}}&nbsp;<small>({{$trans.translation.optional}})</small></label>
                                 <div class="input-group" style="margin-bottom:8px;">
                                     <input type="text" :class="{'input-addon-field': true,'is-error': errors.has('link')}" v-model="link" name="link" placeholder="http://www.yourlink.com">
                                 </div>
                            </div>
                        </div>
                        <div style="position: relative; text-align: right;">
                            <button id="submit-all" class="col-photo-submit" style="margin-top:0;">{{$trans.translation.edit_submit}}</button>
                        </div>
                        </form>
                    </div>
                  </transition>
                  <div v-for="(contact, index) in contacts" v-show="contacts.length" class="round-div margin-top-10px">
                    <table class="c-table">
                      <tr>
                        <td class="s-cell" id="icon"><span class="grey-font" :class="'icon-' + contact.type"></span></td>
                        <td colspan="2" class="m-cell">
                          <div class="input-group">
                            <input type="text" v-model="contact.body">
                            <button class="checkmark-btn" type="button" @click.prevent="updateBody(contact.id,contact.body)"><small class="icon-checkmark"></small></button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td class="m-cell" colspan="2">
                          <div class="input-group">
                            <input type="text" placeholder="http://www.yourlink.com" v-model="contact.link">
                            <button class="checkmark-btn" type="button" @click.prevent="updateLink(contact.id,contact.link)"><small class="icon-checkmark"></small></button>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td></td>
                        <td class="m-cell" colspan="1"><label>{{$trans.translation.show_product}}</label>
                          <input id="checkbox" type="checkbox" v-model="contact.show_product" @change.prevent="toggleShowProduct(contact.id)">
                          {{contact.show_product ? $trans.translation.showing : $trans.translation.hiding}}
                        </td>
                      </tr>

                      <tr>
                        <td></td>
                        <td class="m-cell" colspan="1"><label>{{$trans.translation.show_cover}}</label>
                          <input id="checkbox" type="checkbox" v-model="contact.show_cover" @change.prevent="toggleShowCover(contact.id)">
                          {{contact.show_cover ? $trans.translation.showing : $trans.translation.hiding}}
                        </td>
                        <td class="s-cell"><button type="button" @click.prevent="remove(contact.id, index)" class="delete-btn round-btn float-right"><small class="icon-bin"></small></button></td>
                      </tr>
                    </table>
                  </div>

                <div style="padding-left: 15px;" v-show="!contacts.length"><h4>{{$trans.translation.no_contact}}</h4></div>

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
			url: window.Closet.url,
      locale: window.Closet.locale,
		}
	},
    methods: {
            getContact() {
              this.$Progress.start();
              this.$http.get(this.$root.url + '/' + this.$root.shopSlug + '/edit/info').then((response) => {
                this.contacts = response.body
                this.$Progress.finish();
              });
            },
            updateBody(contactId, contactBody) {
              this.$http.put(this.$root.url + '/' + this.$root.shopSlug + '/edit/info/' + contactId, {
              body: contactBody,
              }).then((response)=> {
                  toastr.success(this.$trans.translation.saved);
              }, (response) => {
                  toastr.error(this.$trans.translation.error);
              });
            },
            updateLink(contactId, contactLink) {
              this.$http.put(this.$root.url + '/' + this.$root.shopSlug + '/edit/info/' + contactId, {
              link: contactLink,
              }).then((response)=> {
                  toastr.success(this.$trans.translation.saved);
              }, (response) => {
                  if (response.body.link) {
                    toastr.error(response.body.link);
                  } else {
                    toastr.error(this.$trans.translation.error);
                  }
              });
            },
            toggleShowProduct(contactId){
              this.$http.put(this.$root.url + '/' + this.$root.shopSlug + '/edit/info/' + contactId + '/show_product').then((response)=> {
                  toastr.success(this.$trans.translation.saved);
              }, (response) => {
                  toastr.error(this.$trans.translation.error);
              });
            },
            toggleShowCover(contactId){
              this.$http.put(this.$root.url + '/' + this.$root.shopSlug + '/edit/info/' + contactId + '/show_cover').then((response)=> {
                  toastr.success(this.$trans.translation.saved);
              }, (response) => {
                  toastr.error(this.$trans.translation.error);
              });
            },
            edit() {
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 2000;
                    this.$Progress.start();
                    toastr.info(this.$trans.translation.wait);
                    this.$http.post(this.$root.url + '/' + this.$root.shopSlug + '/edit/info', {
                    type: this.type,
                    body: this.body,
                    link: this.link,
                    }).then((response)=> {
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

            remove(contactId, index){
              if(!confirm(this.$trans.translation.delete_confirm)){
                return;
              }
              this.$http.delete(this.$root.url + '/' + this.$root.shopSlug + '/edit/info/' + contactId + '/delete').then((response)=> {
                  toastr.success(this.$trans.translation.success);
                  this.contacts.splice(index, 1)
              }, (response) => {
                  toastr.error(this.$trans.translation.error);
              });
            }
    },
    created() {
      this.getContact();
    }
}
</script>
