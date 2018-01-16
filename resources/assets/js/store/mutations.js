export const setCount = (state, items) => {
  state.cart = items
}

export const checkout = (state, {shop}) => {
  console.log('work');
  state.checkout.push({ shop })
}
export const removeCount = (state) => {
  state.cart.splice(0, 1)
}
export const appendToCart = (state, { product, choice }) => {
  const existing = state.cart.find((item) => {
    return item.id === product.id && item.choice == choice
  })
  const id = product.id
  if (existing) {

  } else {
    state.cart.push({
      id, choice
    })
  }
}
