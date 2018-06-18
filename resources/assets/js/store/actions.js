import axios from 'axios'

export const addToCart = ({ commit }, { product, choice, shipping, stock }) => {

  commit('appendToCart', { product, choice, shipping, stock } )

  return axios.post('http://closet.local:8000/cart/add/' + product.name, {
    product, choice, shipping, stock
  })

}

export const getCartCount = ({ commit }) => {

  return axios.get('http://closet.local:8000/cart/get').then((response) => {

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
