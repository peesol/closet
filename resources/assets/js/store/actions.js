import Vue from 'vue'

export const addToCart = ({ commit }, { product, choice, shipping, stock }) => {

  commit('appendToCart', { product, choice, shipping, stock } )

  return Vue.http.post(window.Closet.url + '/cart/add/' + product.name, {
    product, choice, shipping, stock
  })

}

export const getCartCount = ({ commit }) => {

  return Vue.http.get(window.Closet.url + '/cart/get').then((response) => {

    commit('setCount', response.data)

    return Promise.resolve()
  })
}

export const addToCheckout = ({ commit }, { shop }) => {
  commit('checkout', { shop } )
}

export const removeFromCart = ({ commit }) => {
  commit('removeCount')
}
