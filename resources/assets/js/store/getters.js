export const count = (state) => {
  return state.cart.length
}

export const notificationCount = (state) => {
  var count = 0;
  state.notification.forEach(function (item) {
    if(!item.read) {
       count++;
     }
  });

  return count
}

export const notifications = (state) => {
  return state.notification
}

export const notificationsRead = (state) => {
  return state.all_read
}
