export const setCount = (state, items) => {
  state.cart = items
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

export const addToNotifications = (state, { notification }) => {
    state.notification.unshift(notification)
    state.all_read = false
}

export const setNotificationCount = (state, items) => {
  state.notification = items
  var read = [];
  state.notification.forEach(function (item) {
    read.push(item.read)
  });
  if (read.every( (val, i, arr) => val === true )) {
    state.all_read = true
  } else {
    state.all_read = false
  }
}

export const markAllAsRead = (state) => {
  if (!state.all_read) {
    state.notification.forEach(function (item) {
      item.read = true
    });
    state.all_read = true
  }
}

export const clearNotifications = (state) => {
  state.all_read = true
  state.notification = []
}
