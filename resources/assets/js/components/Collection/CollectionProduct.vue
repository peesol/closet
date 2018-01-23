<template>
<div>
	<div id="col-add" v-show="user_id !== null">
		<button v-on-clickaway="hide" class="add-to-col" @click.prevent="formVisible = !formVisible" v-bind:class="{'add-to-col-active': formVisible === true}">{{$trans.translation.add_to_col}}</button>
        <transition name="opacity">
            <div @click.stop class="col-add" id="col-add-id" v-show="formVisible">
                <ul id="col-add-id">
                    <li v-show="collections.length == 0"><p style="margin-left: 8px;">&nbsp;{{$trans.translation.col_null}}</p></li>
                    <li id="col-add-id" v-for="(collection, index) in collections"><a @click.prevent="addToCollection(productId,collection.id, index)"
                    v-bind:class="{'added': collection.added === true}"
                    >{{ collection.name }}</a></li>
                </ul>
                                    <li><button @click.prevent="create = !create" class="create-col">{{$trans.translation.add_col}}</button></li>
                    <transition name="slide-down-col">
                    <li class="col-add-li" v-show="create"><input class="col-add-input" type="text" v-model="col_name"><button @click.prevent="createCol"><span class="icon-checkmark grey-font"></span></button></li>
                    </transition>
            </div>
        </transition>
	</div>

</div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
    export default {
        mixins: [ clickaway ],
    	data() {
    		return {
          col_name: null,
    			collections:[],
          added: null,
          formVisible: false,
    			create: false,
          url: window.Closet.url,
          user_id: window.Closet.user.user,
          trans: this.$trans,
    		}
    	},

    	methods: {
        getCollection() {
          this.$http.get(this.url + '/collection_ajax/'+ this.shopSlug +'/add/' + this.productId).then((response)=> {
              this.collections = response.body.data;
            });
        },
    		addToCollection(productId, collectionId, index) {
					this.$http.post(this.url + '/collection/' + collectionId + '/add/' + productId).then((response)=> {
						if (this.collections[index].added) {
							this.$set(this.collections[index], 'added', false)
							toastr.success(this.$trans.translation.delete_from_col)
						} else {
							this.$set(this.collections[index], 'added', true)
							toastr.success(this.$trans.translation.added_to_col)
						}

    				}, (response) => {
    					toastr.error(this.$trans.translation.error);
      				});
    		},
        hide () {
          this.formVisible = false;
        },
        createCol () {
          this.$http.post(this.url + '/collection_ajax/' + this.shopSlug ,{
              name: this.col_name,
          }).then((response)=> {
						this.col_name = null,
						this.collections.push(response.body)
            toastr.success(this.$trans.translation.col_created);
          });
        }

    	},

        props: {
        	productId: null,
        	shopSlug: null,
        },

      created() {
            this.getCollection();
  		},

    }
</script>
