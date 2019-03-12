export const SET_USER = (state, user) => state.user = user

export const SET_READ = (state, notifications) => {
  state.read = filter(notifications, notification => notification.read_at !== null)
} 

export const SET_UNREAD = (state, notifications) => {
  state.unread = filter(notifications, notification => notification.read_at === null)
}

export const SET_APPRENTICE_NAMES = (state, notifications) => {
  let apprenticeNames = []

  forEach(notifications, notification => {
    apprenticeNames.push(notification.data.userlessonUserName)
  })

  state.apprenticeNames = _.uniq(apprenticeNames)
}

export const DELETE_NOTIFICATION = (state, notificationId) =>  {
  state.read = filter(state.read, notification => notificationId !== notification.id)

  state.unread = filter(state.unread, notification => notificationId !== notification.id)
}