<template>
<div v-on-clickaway="hide" class="align-right full-height" v-show="$root.authenticated">
  <button class="dropdown-btn light" @click.prevent="toggle(1)" v-bind:class="{'btn-active': formVisible === 1}"><i class="fas fa-plus"></i></button>

  <div @click.stop class="col-add shadow-1" v-show="formVisible === 1">
    <ul id="full-line">
      <li v-show="collections.length === 0">
        <p class="align-center">{{$trans.translation.col_null}}</p>
      </li>
      <li>
        <a @click.prevent="addToNote()">
            <i :class="{'fas fa-book font-green' : addedToNote, 'fas fa-book font-grey' : !addedToNote}"></i>
            &nbsp;{{$trans.translation.my_note}}
          </a>
      </li>
      <li v-for="(collection, index) in collections">
        <a class="text-nowrap" @click.prevent="addToCollection(productId,collection.id, index)">
            <i :class="{'fas fa-check-square font-green' : collection.added, 'far fa-square' : !collection.added}"></i>
            &nbsp;{{ collection.name }}
          </a>
      </li>
    </ul>
    <li>
      <button @click.prevent="create = !create" class="flat-btn full-width padding-15-vertical">
          <font class="font-medium">{{$trans.translation.add_col}}</font>
        </button>
    </li>

    <li class="input-group padding-10" v-show="create">
      <input class="input-addon-field left" type="text" v-model="col_name">
      <button class="checkmark-btn input-addon right" @click.prevent="createCol">
            <i class="fas fa-check"></i>
          </button>
    </li>
  </div>
  <button class="dropdown-btn light fas fa-ellipsis-v" @click.prevent="toggle(2)" v-bind:class="{'btn-active': formVisible === 2}"></button>
  <div @click.stop class="col-add shadow-1" v-show="formVisible === 2">
    <ul id="full-line">
      <li>
        <a href="#" @click.prevent="report()">{{$trans.translation.report_product}}</a>
      </li>
    </ul>
  </div>

</div>
</template>

<script>
import {
  mixin as clickaway
} from 'vue-clickaway';
export default {
  mixins: [clickaway],
  data() {
    return {
      col_name: null,
      collections: [],
      addedToNote: this.noted,
      formVisible: null,
      create: false,
    }
  },
  props: {
    productId: null,
    productSlug: null,
    shopSlug: null,
    noted: null,
  },
  methods: {
    toggle(number) {
      if (this.formVisible === number) {
        this.formVisible = null
      }
      this.formVisible = number
    },
    getCollection() {
      this.$http.get(this.$root.url + '/collection_api/' + this.shopSlug + '/add/' + this.productId).then(response => {
        this.collections = response.body.data;
      });
    },
    addToCollection(productId, collectionId, index) {
      this.$http.post(this.$root.url + '/collection/' + collectionId + '/add/' + productId).then(response => {
        if (this.collections[index].added) {
          this.$set(this.collections[index], 'added', false)
          toastr.success(this.$trans.translation.delete_from_col)
        } else {
          this.$set(this.collections[index], 'added', true)
          toastr.success(this.$trans.translation.added_to_col)
        }
      }, response => {
        toastr.error(this.$trans.translation.error)
      });
    },
    addToNote() {
      this.$http.post(this.$root.url + '/profile/note/add', {
        shop_id: this.$root.user,
        product_id: this.productId
      }).then(response => {
        if (this.addedToNote) {
          this.addedToNote = false
          toastr.success(this.$trans.translation.success)
        } else {
          this.addedToNote = true
          toastr.success(this.$trans.translation.success)
        }
      }, response => {
        toastr.error(this.$trans.translation.error)
      })
    },
    hide() {
      this.formVisible = null;
    },
    createCol() {
      this.$http.post(this.$root.url + '/collection_api/' + this.shopSlug, {
        name: this.col_name,
      }).then(response => {
        this.col_name = null
        this.collections.push(response.body.data)
        toastr.success(this.$trans.translation.col_created);
      }, response => {
        toastr.error(this.$trans.translation.error);
      });
    },
    report() {
      document.location.href = this.$root.url + '/report/product/' + this.productSlug
    }

  },

  created() {
    if (this.$root.authenticated) {
      this.getCollection()
    }
  },
}
</script>
