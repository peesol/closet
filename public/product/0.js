webpackJsonp([0],{

/***/ 188:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(189),
  /* template */
  __webpack_require__(190),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/projects/closet/resources/assets/js/components/Product/ProductComment.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ProductComment.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fe1a8200", Component.options)
  } else {
    hotAPI.reload("data-v-fe1a8200", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 189:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
	data: function data() {
		return {
			comments: [],
			body: null,
			replyBody: null,
			replyFormVisible: null,
			showReply: null,
			user_id: window.Closet.user.user
		};
	},

	props: {
		productUid: null
	},
	methods: {
		toggleReply: function toggleReply(commentId) {

			if (this.showReply === commentId) {
				this.showReply = null;
				return;
			}

			this.showReply = commentId;
		},
		toggleReplyForm: function toggleReplyForm(commentId) {

			this.replyBody = null;

			if (this.replyFormVisible === commentId) {
				this.replyFormVisible = null;
				return;
			}

			this.replyFormVisible = commentId;
		},
		createReply: function createReply(commentId) {
			var _this = this;

			this.$http.post(this.$root.url + '/product/' + this.productUid + '/comments', {
				body: this.replyBody,
				reply_id: commentId
			}).then(function (response) {
				_this.comments.map(function (comment, index) {
					_this.replyBody = null;
					if (comment.id === commentId) {
						_this.comments[index].replies.data.push(response.body.data);
						_this.toggleReplyForm(commentId);
						_this.toggleReply(commentId);
					}
				});
			}, function (response) {
				toastr.error(response.body.body);
			});
		},
		createComment: function createComment() {
			var _this2 = this;

			this.$http.post(this.$root.url + '/product/' + this.productUid + '/comments', {
				body: this.body
			}).then(function (response) {
				_this2.comments.unshift(response.body.data);
				_this2.body = null;
			}, function (response) {
				toastr.error(response.body.body);
			});
		},
		deleteComment: function deleteComment(commentId) {
			var _this3 = this;

			if (!confirm(this.$trans.translation.comment_delete_confirm)) {
				return;
			}

			this.$http.delete(this.$root.url + '/product/' + this.productUid + '/comments/' + commentId).then(function () {
				_this3.deleteById(commentId);
			});
		},
		deleteById: function deleteById(commentId) {
			var _this4 = this;

			this.comments.map(function (comment, index) {
				if (comment.id === commentId) {
					_this4.comments.splice(index, 1);
					return;
				}

				comment.replies.data.map(function (reply, replyIndex) {
					if (reply.id === commentId) {
						_this4.comments[index].replies.data.splice(replyIndex, 1);
						return;
					}
				});
			});
		},
		getComments: function getComments() {
			var _this5 = this;

			this.$Progress.start();
			this.$http.get(this.$root.url + '/product/' + this.productUid + '/comments').then(function (response) {
				_this5.comments = response.body.data;
				_this5.$Progress.finish();
			});
		}
	},
	created: function created() {
		this.getComments();
	}
});

/***/ }),

/***/ 190:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "comments-wrap"
  }, [_c('vue-progress-bar'), _vm._v(" "), _c('div', {
    staticClass: "comments-header"
  }, [_c('p', [_vm._v(_vm._s(_vm.comments.length) + " " + _vm._s(_vm.comments.length > 1 ? _vm.$trans.translation.comments : _vm.$trans.translation.comment))])]), _vm._v(" "), (_vm.$root.authenticated) ? _c('div', {
    staticClass: "panel-body relative",
    attrs: {
      "id": "full-line"
    }
  }, [_c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.body),
      expression: "body"
    }],
    staticClass: "description-input",
    staticStyle: {
      "height": "100px"
    },
    attrs: {
      "placeholder": _vm.$trans.translation.comment + '...'
    },
    domProps: {
      "value": (_vm.body)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.body = $event.target.value
      }
    }
  }), _vm._v(" "), _c('button', {
    staticClass: "btn margin-10-top",
    staticStyle: {
      "margin-left": "auto",
      "display": "block"
    },
    attrs: {
      "type": "submit"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.createComment($event)
      }
    }
  }, [_vm._v(_vm._s(_vm.$trans.translation.comment))])]) : _vm._e(), _vm._v(" "), _vm._l((_vm.comments), function(comment) {
    return _c('div', {
      staticClass: "panel-body"
    }, [_c('div', {
      staticClass: "comments-thumb"
    }, [_c('a', {
      attrs: {
        "href": '/' + comment.shop.data.slug
      }
    }, [_c('img', {
      staticClass: "round-btn",
      attrs: {
        "src": comment.shop.data.image,
        "alt": comment.shop.data.name
      }
    })])]), _vm._v(" "), _c('div', {
      staticClass: "comments-body"
    }, [_c('div', {
      staticClass: "comments-info"
    }, [_c('p', {
      staticClass: "no-margin"
    }, [_c('a', {
      staticClass: "link-text font-bold",
      attrs: {
        "href": '/' + comment.shop.data.slug
      }
    }, [_vm._v(_vm._s(comment.shop.data.name))]), _vm._v(" " + _vm._s(comment.created_at_human))]), _vm._v(" "), _c('p', {
      staticClass: "comment"
    }, [_vm._v(_vm._s(comment.body))])]), _vm._v(" "), _c('div', {
      staticClass: "comments-action"
    }, [_c('font', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (_vm.user_id === comment.user_id),
        expression: "user_id === comment.user_id"
      }],
      staticClass: "link-text",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.deleteComment(comment.id)
        }
      }
    }, [_vm._v(_vm._s(_vm.$trans.translation.delete))]), _vm._v(" "), _c('font', {
      staticClass: "link-text",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.toggleReplyForm(comment.id)
        }
      }
    }, [_vm._v(_vm._s(_vm.replyFormVisible === comment.id ? _vm.$trans.translation.cancle : _vm.$trans.translation.reply))])], 1), _vm._v(" "), _c('transition', {
      attrs: {
        "name": "slide-down-reply"
      }
    }, [_c('div', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (_vm.replyFormVisible === comment.id),
        expression: "replyFormVisible === comment.id"
      }],
      staticClass: "input-group margin-10-top"
    }, [_c('input', {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: (_vm.replyBody),
        expression: "replyBody"
      }],
      staticClass: "input-addon-field",
      attrs: {
        "type": "text"
      },
      domProps: {
        "value": (_vm.replyBody)
      },
      on: {
        "input": function($event) {
          if ($event.target.composing) { return; }
          _vm.replyBody = $event.target.value
        }
      }
    }), _vm._v(" "), _c('button', {
      staticClass: "input-addon",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.createReply(comment.id)
        }
      }
    }, [_c('span', {
      staticClass: "icon-next-arrow"
    })])])]), _vm._v(" "), (comment.replies.data.length) ? _c('div', {
      staticClass: "full-label"
    }, [_c('font', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (_vm.showReply === comment.id),
        expression: "showReply === comment.id"
      }],
      staticClass: "link-text",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.toggleReply(comment.id)
        }
      }
    }, [_vm._v(_vm._s(comment.replies.data.length > 1 ? _vm.$trans.translation.show_reply : _vm.$trans.translation.hide_reply) + " "), _c('span', {
      staticClass: "icon-arrows-up",
      staticStyle: {
        "font-size": "10px"
      }
    })]), _vm._v(" "), _c('font', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (_vm.showReply !== comment.id),
        expression: "showReply !== comment.id"
      }],
      staticClass: "link-text",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.toggleReply(comment.id)
        }
      }
    }, [_vm._v(_vm._s(comment.replies.data.length > 1 ? _vm.$trans.translation.hide_reply : _vm.$trans.translation.show_reply) + " "), _c('span', {
      staticClass: "icon-arrows-down",
      staticStyle: {
        "font-size": "10px"
      }
    })])], 1) : _vm._e(), _vm._v(" "), _vm._l((comment.replies.data), function(reply) {
      return (_vm.showReply === comment.id) ? _c('div', [_c('div', {
        staticClass: "comments-thumb"
      }, [_c('a', {
        staticClass: "link-text",
        attrs: {
          "href": '/' + reply.shop.data.slug
        }
      }, [_c('img', {
        staticClass: "round-btn",
        attrs: {
          "src": reply.shop.data.image,
          "alt": reply.shop.data.name
        }
      })])]), _vm._v(" "), _c('div', {
        staticClass: "comments-body"
      }, [_c('p', {
        staticClass: "no-margin"
      }, [_c('a', {
        staticClass: "link-text",
        attrs: {
          "href": '/' + reply.shop.data.slug
        }
      }, [_vm._v(_vm._s(reply.shop.data.name))]), _vm._v(" " + _vm._s(reply.created_at_human))]), _vm._v(" "), _c('div', {
        staticClass: "comments-area"
      }, [_c('p', {
        staticClass: "comment"
      }, [_vm._v(_vm._s(reply.body))])]), _vm._v(" "), _c('div', {
        directives: [{
          name: "show",
          rawName: "v-show",
          value: (_vm.user_id === reply.user_id),
          expression: "user_id === reply.user_id"
        }],
        staticClass: "reply-list-wrap"
      }, [_c('font', {
        staticClass: "link-text",
        on: {
          "click": function($event) {
            $event.preventDefault();
            _vm.deleteComment(reply.id)
          }
        }
      }, [_vm._v(_vm._s(_vm.$trans.translation.delete))])], 1)])]) : _vm._e()
    })], 2)])
  })], 2)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-fe1a8200", module.exports)
  }
}

/***/ })

});