
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Laravel = { csrfToken: $('meta[name=csrf-token]').attr("content") };

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-resource'))
Vue.use(require('vee-validate'))
Vue.use(require('numeral'))

import VModal from 'vue-js-modal'
Vue.use(VModal)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: '#ff8300',
  failedColor: 'red',
  thickness: '5px'
});

import router from './router'

import Vuex from 'vuex'
Vue.use(Vuex)

const mutations = require('./store/mutations');
const actions = require('./store/actions');
const getters = require('./store/getters');
const store = new Vuex.Store({
  mutations,
  actions,
  getters,
  state: {
    cart: [],
    count: null
  },
})

window.addEventListener('load', function () {
  const details = new Vue({
    el: '.product-details',
    store
  });
  const cart = new Vue({
    el: '.cart',
    store
  });
});

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});

Vue.component('product-vote', require('./components/Product/ProductVote.vue'));
Vue.component('product-comment', require('./components/Product/ProductComment.vue'));
Vue.component('product-edit', require('./components/Product/ProductEdit.vue'));
Vue.component('product-dropzone', require('./components/Product/ProductDropzone.vue'));
Vue.component('product-shipping', require('./components/Product/ProductShipping.vue'));
Vue.component('product-sell', require('./components/Product/ProductSell.vue'));
Vue.component('used-sell', require('./components/Product/ProductSell_used.vue'));
Vue.component('used-comment', require('./components/Product/ProductComment_used.vue'));
Vue.component('product-stock', require('./components/Product/ProductStock.vue'));
Vue.component('product-choice', require('./components/Product/ProductChoice.vue'));
Vue.component('follow-button', require('./components/Follow.vue'));
Vue.component('add-to-cart', require('./components/Product/AddToCart.vue'));
Vue.component('cart-icon', require('./components/CartIcon.vue'));
Vue.component('cart', require('./components/Cart.vue'));
Vue.component('shop-stats', require('./components/Shop/ShopStats.vue'));
Vue.component('shop-vote', require('./components/Shop/ShopVote.vue'));
Vue.component('shop-edit', require('./components/Shop/ShopEdit.vue'));
Vue.component('shop-cover-edit', require('./components/Shop/ShopCoverEdit.vue'));
Vue.component('shop-thumbnail-edit', require('./components/Shop/ShopThumbnailEdit.vue'));
Vue.component('shop-collection', require('./components/Shop/ShopCollection.vue'));
Vue.component('shop-contact-edit', require('./components/Shop/ShopContactEdit.vue'));
Vue.component('shop-account-edit', require('./components/Shop/ShopAccountEdit.vue'));
Vue.component('collection-edit', require('./components/Collection/CollectionEdit.vue'));
Vue.component('collection-dropzone', require('./components/Collection/CollectionDropzone.vue'));
Vue.component('collection-product', require('./components/Collection/CollectionProduct.vue'));
Vue.component('collection-product-edit', require('./components/Collection/CollectionProductEdit.vue'));
Vue.component('collection-product-show', require('./components/Collection/CollectionProductShow.vue'));
Vue.component('language-select', require('./components/Language.vue'));
Vue.component('showcase', require('./components/Showcase.vue'));
Vue.component('showcase-edit', require('./components/ShowcaseEdit.vue'));
Vue.component('shipping-edit', require('./components/ShippingEdit.vue'));
Vue.component('order-selling', require('./components/Order/Selling.vue'));
Vue.component('order-buying', require('./components/Order/Buying.vue'));
Vue.component('confirm-selling', require('./components/Order/ConfirmSelling.vue'));
Vue.component('confirm-trans', require('./components/Order/ConfirmTrans.vue'));
Vue.component('cant-sell', require('./components/Product/CantSell.vue'));

const translations = {
    en: {
        sell: 'Sell something',
        product_name: 'Product Name',
        products: 'Products',
        product: 'Product',
        product_none: 'You don\'t have any product.',
        price: 'Price',
        category: 'Category',
        subcategory: 'Subcategory',
        type: 'Product Type',
        description: 'Description',
        by: 'By',
        sell_submit: 'Submit',
        thumbnail: 'Thumbnail',
        cover: 'Cover',
        choose_file: 'Choose File',
        remove: 'Remove',
        edit_submit: 'Save',
        photos: 'Photos',
        upload_photo: 'Upload Photo',
        upload_photo_size: 'Uploaded Photo will be resized to 500px * 500px',
        delete_photo_confirm: 'Are you sure you want to delete this photo?',
        delete_confirm: 'Are you sure you want to delete this?',
        upload_submit: 'Upload',
        name: 'Name',
        shop_name: 'Closet Name',
        shop_url: 'Unique URL',
        email: 'E-mail',
        phone: 'Phone',
        link: 'Link',
        col_name: 'Name',
        visibility: 'Visibility',
        public: 'Public',
        private: 'Private',
        add_col: 'Add collection +',
        col_photo_limit: 'You can\'t upload more than 10 photos.',
        col_photo_none: 'This collection has no photo.',
        col_product_none: 'This collection has no product.',
        col_none: 'No collection.',
        col_created: 'Collection created.',
        col_deleted: 'Collection deleted.',
        col_delete_confirm: 'Are you sure you want to delete this collection?',
        create: 'Create',
        add_to_col: 'Add to',
        delete_from_col: 'this product is deleted from collection.',
        added_to_col: 'this product is added to collection.',
        col_null: 'You don\'t have any collection.',
        follow: 'Follow',
        followers: 'Followers',
        follower: 'Follower',
        unfollow: 'Unfollow',
        likes: 'Likes',
        like: 'Like',
        dislikes: 'Dislikes',
        dislike: 'Dislike',
        comments: 'Comments',
        comment: 'Comment',
        comment_delete_confirm: 'Are you sure that you want to delete this comment?',
        reply: 'Reply',
        delete: 'Delete',
        cancle: 'Cancle',
        edit: 'Edit',
        show_reply: 'Show reply',
        hide_reply: 'Hide reply',
        login_first: 'Please Login.',
        login: 'Login',
        success: 'Success',
        error: 'Error',
        wait: 'Please wait...',
        saved: 'Saved',
        dropzone_null: 'Nothing to upload.',
        fill_every: 'Please fill out every field.',
        product_photo_limit: 'You can upload up to 7 photos.',
        used_notice: 'Used product is valid for 30 days and will be removed after.',
        new: 'New',
        used: 'Used',
        create_showcase: 'Create showcase +',
        showcase_created: 'Showcase created.',
        showcase_add: 'Add',
        showcase_empty: 'Your showcase has no product.',
        showcase_products: 'Products in your showcase',
        showcase_choice: 'Show on your shop homepage',
        showcase_drag: 'You can change the order of your showcases by dragging the number.',
        no_showcase: 'You don\'t have any showcase.',
        no_contact: 'You don\'t have any contact.',
        no_account: 'You don\'t have any account.',
        shop_products: 'My products',
        show: 'Show',
        hide: 'Hide',
        showing: 'Showing',
        hiding: 'Hiding',
        yes: 'Yes',
        no: 'No',
        days: 'Days',
        baht: 'Baht',
        min: 'Min',
        max: 'Max',
        stock_edit: 'Stock management',
        stock: 'Instock',
        amount: 'Amount',
        shipping: 'Shipping',
        shipping_time: 'Shipping within',
        shipping_free: 'Shipping for free?',
        shipping_fee: 'Shipping fee',
        shipping_inter: 'Shipping international?',
        shipping_ex: 'ex.Post,DHL,etc.',
        choice_add: 'Add options',
        choice: 'Options',
        choice_name_ex: 'ex.color,size',
        current_choices: 'This product options',
        website: 'Website',
        location: 'Location',
        optional: 'Optional',
        add: 'Add +',
        show_product: 'Show on product page',
        show_cover: 'Show on cover',
        field: 'this field',
        added_to_cart: 'Added to cart',
        add_to_cart: 'Add to cart',
        total_price: 'total price',
        order: 'Order',
        pending_order: 'Pending...',
        wait_transaction: 'Waiting for transaction',
        completed_transaction: 'Payment confirmed',
        transacted: 'Transaction confirmed',
        shipped: 'Delivered',
        confirm_order: 'Confirm',
        close: 'Close',
        confirm: 'Confirm',
        deny: 'Deny',
        deny_confirm: 'Deny this order?',
        account_number: 'Account number',
        account_name: 'Account name',
        account_provider: 'Provider',
        address: 'Address for delivery',
        track_info: 'Carrier service',
        track_number: 'Tracking number',
        delivered: 'Delivered',
        payment_date: 'Payment date',
        wait_delivery: 'Wait for delivery',
        date_placeholder: 'dd/mm/YY',
      },

    th: {
        sell: 'ขายสินค้า',
        product_name: 'ชื่อสินค้า',
        products: 'สินค้า',
        product: 'สินค้า',
        product_none: 'คุณไม่มีสินค้าเลย',
        price: 'ราคา',
        category: 'หมวดหมู่',
        subcategory: 'หมวดหมู่รอง',
        type: 'ประเภทสินค้า',
        description: 'รายละเอียด',
        by: 'โดย',
        sell_submit: 'ลงขาย',
        thumbnail: 'รูปขนาดย่อ',
        cover: 'รูปภาพหน้าปก',
        choose_file: 'เลือกรูป',
        remove: 'ลบ',
        edit_submit: 'บันทึก',
        photos: 'รูปภาพ',
        upload_photo: 'อัพโหลดรูปภาพ',
        upload_photo_size: 'รูปภาพที่อัพโหลดจะถูกเปลี่ยนขนาดเป็น 500px * 500px',
        delete_photo_confirm: 'คุณแน่ใจหรือไม่ว่าจะลบรูปภาพนี้?',
        delete_confirm: 'คุณแน่ใจหรือไม่ว่าจะลบ?',
        upload_submit: 'อัพโหลด',
        name: 'ชื่อ',
        shop_name: 'ชื่อร้าน',
        shop_url: 'URL ของร้าน',
        email: 'อีเมล',
        phone: 'โทรศัพท์',
        link: 'ลิงค์',
        col_name: 'ชื่อคอลเล็คชั่น',
        visibility: 'ใครดูได้',
        public: 'สาธาณะ',
        private: 'ส่วนตัว',
        add_col: 'สร้างคอลเล็คชั่น +',
        col_photo_limit: 'คุณสามารถมีรูปภาพได้ไม่เกิน 10 รูป',
        col_photo_none: 'คอลเล็คชั่นนี้ไม่มีรูป',
        col_product_none: 'คอลเล็คชั่นนี้ไม่มีสินค้า',
        col_none: 'ไม่มีคอลเล็คชั่น',
        col_created: 'สร้างคอลเล็คชั่นแล้ว',
        col_deleted: 'ลบคอลเล็คชั่นแล้ว',
        col_delete_confirm: 'คุณแน่ใจหรือไม่ว่าจะลบคอลเล็คชั่นนี้?',
        create: 'สร้าง',
        add_to_col: 'เพิ่มลงใน',
        delete_from_col: 'ลบออกจากคอลเล็คชั่นแล้ว',
        added_to_col: 'เพิ่มลงในคอลเล็คชั่นแล้ว',
        col_null: 'คุณไม่มีคอลเล็คชั่น',
        follow: 'ติดตาม',
        followers: 'ผู้ติดตาม',
        follower: 'ผู้ติดตาม',
        unfollow: 'เลิกติดตาม',
        likes: 'ถูกใจ',
        like: 'ถูกใจ',
        dislikes: 'ไม่ถูกใจ',
        dislike: 'ไม่ถูกใจ',
        comments: 'คอมเมนต์',
        comment: 'คอมเมนต์',
        comment_delete_confirm: 'คุณแน่ใจหรือไม่ว่าจะลบคอมเมนต์นี้?',
        reply: 'ตอบ',
        delete: 'ลบ',
        cancle: 'ยกเลิก',
        edit: 'แก้ไข',
        show_reply: 'แสดง',
        hide_reply: 'ซ่อน',
        login_first: 'โปรดล็อกอินก่อน',
        login: 'ล็อกอิน',
        success: 'สำเร็จ',
        error: 'เกิดข้อผิดพลาด',
        wait: 'โปรดรอ...',
        saved: 'บันทึกแล้ว',
        dropzone_null: 'ไม่มีอะไรให้อัพโหลด',
        fill_every: 'กรุณากรอกข้อมูลให้ครบทุกช่อง',
        product_photo_limit: 'คุณสามารถอัพโหลดรูปสินค้าได้สูงสุด 7 รูป',
        used_notice: 'สินค้ามือสองจะถูกลบโดยอัตโนมัติ 30 วัน หลังจากลงขาย',
        new: 'สินค้าใหม่',
        used: 'มือสอง',
        create_showcase: 'สร้างตู้แสดงสินค้า +',
        showcase_created: 'สร้างตู้แสดงสินค้าแล้ว',
        showcase_add: 'เพิ่ม',
        showcase_empty: 'ตู้แสดงสินค้าของคุณไม่มีสินค้า',
        showcase_products: 'สินค้าที่แสดงอยู่',
        showcase_choice: 'แสดงบนหน้าแรกของร้าน',
        showcase_drag: 'คุณสามารถจัดลำดับของตู้โชว์ได้โดยการลากปุ่มตัวเลข',
        no_showcase: 'คุณไม่มีตู้แสดงสินค้า',
        no_contact: 'คุณไม่มีช่องทางการติดต่อ',
        no_account: 'คุณไม่มีบัญชีธนาคาร',
        shop_products: 'สินค้าในร้านของฉัน',
        show: 'แสดง',
        hide: 'ซ่อน',
        showing: 'แสดงอยู่',
        hiding: 'ไม่แสดง',
        yes: 'ใช่',
        no: 'ไม่',
        days: 'วัน',
        baht: 'บาท',
        min: 'ต่ำสุด',
        max: 'สูงสุด',
        stock_edit: 'การจัดการสต๊อกสินค้า',
        stock: 'มีสินค้า',
        amount: 'จำนวน',
        shipping: 'การจัดส่ง',
        shipping_time: 'ส่งภายใน',
        shipping_free: 'ส่งฟรีหรือไม่',
        shipping_fee: 'ค่าขนส่ง',
        shipping_inter: 'ส่งไปต่างประเทศ?',
        shipping_ex: 'เช่น EMS kerry หรืออื่นๆ',
        choice_add: 'เพิ่มตัวเลือก',
        choice: 'ตัวเลือก',
        choice_name_ex: 'เช่น สี ไซส์',
        current_choices: 'ตัวเลือกของสินค้านี้',
        website: 'เว็บไซต์',
        location: 'ที่อยู่',
        optional: 'ไม่มีก็ได้',
        add: 'เพิ่ม +',
        show_product: 'แสดงที่สินค้าของฉัน',
        show_cover: 'แสดงที่หน้าร้าน',
        field: 'ข้อมูล',
        added_to_cart: 'เพิ่มในตะกร้าแล้ว',
        add_to_cart: 'เพิ่มลงตระกร้า',
        total_price: 'รวมทั้งหมด',
        order: 'รายการสั่งซื้อ',
        pending_order: 'รายการที่ยังไม่ยืนยัน',
        wait_transaction: 'รอแจ้งชำระเงิน',
        completed_transaction: 'แจ้งชำระเงินแล้ว',
        transacted: 'แจ้งโอนเงินแล้ว',
        shipped: 'ส่งสินค้าแล้ว',
        confirm_order: 'ยืนยันการสั่งซื้อ',
        close: 'ปิด',
        confirm: 'ยืนยัน',
        deny: 'ปฏิเสธ',
        deny_confirm: 'ปฏิเสธรายการนี้?',
        account_number: 'เลขที่บัญชี',
        account_name: 'ชื่อบัญชี',
        account_provider: 'ธนาคาร',
        address: 'ที่อยู่ในการจัดส่ง',
        track_info: 'ผู้ให้บริการขนส่ง',
        track_number: 'เลขติดตามพัสดุ',
        delivered: 'ส่งสินค้าแล้ว',
        payment_date: 'เวลาที่ชำระเงิน',
        wait_delivery: 'รอส่งสินค้า',
        date_placeholder: 'วัน/เดือน/ปี',
    },
    translation:[],
    translate(lang) {
      if(lang === 'en') {
        this.translation = this.en;
      } else if (lang === 'th') {
        this.translation = this.th;
      }
    },

}

translations.install = function(){
  Object.defineProperty(Vue.prototype, '$trans', {
    get: function () { return translations; }
  });
}

Vue.use(translations);
