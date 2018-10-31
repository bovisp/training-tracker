export const setReadNotifications = (state, notifications) => {
	state.read = filter(notifications, notification => notification.data.read_at !== null)
} 

export const setUnreadNotifications = (state, notifications) => {
	state.unread = filter(notifications, notification => notification.data.read_at === null)
}

export const setUser = (state, user) => state.user = user

export const deleteNotification = (state, notificationId) =>  {
	state.read = filter(state.read, notification => notificationId !== notification.data.id)

	state.unread = filter(state.unread, notification => notificationId !== notification.data.id)
}

export const markAsRead = (state, notificationId) => {
	state.read = filter(state.read, notification => notificationId !== notification.data.id)

	state.read.push(find(state.unread, { meta: { id: notificationId }}))
}