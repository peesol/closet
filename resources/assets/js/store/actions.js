import axios from 'axios'

export const addToCart = ({ commit }, { product, choice }) => {

  commit('appendToCart', { product, choice } )

  return axios.post('https://closet.plus/cart/add/' + product.uid, {
    product, choice
  })

}

export const getCartCount = ({ commit }) => {

  return axios.get('https://closet.plus/cart/get').then((response) => {

    commit('setCount', response.data)

    return Promise.resolve()
  })
}
