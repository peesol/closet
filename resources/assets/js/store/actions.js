import axios from 'axios'

export const addToCart = ({ commit }, { product, choice }) => {

  commit('appendToCart', { product, choice } )

  return axios.post('http://closet.app:8000/cart/add/' + product.uid, {
    product, choice
  })

}

export const getCartCount = ({ commit }) => {

  return axios.get('http://closet.app:8000/cart/get').then((response) => {

    commit('setCount', response.data)

    return Promise.resolve()
  })
}
