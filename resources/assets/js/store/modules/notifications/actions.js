export const fetch = async ({ commit }, userId) => {
	commit('loadingStatus', null, { root: true })

	let response = await axios.get(`${urlBase}/users/${userId}/notifications/api`)

	console.log(response)

	await commit('setUnreadNotifications', response.data.notifications)

	await commit('setReadNotifications', response.data.notifications)

	await commit('setUser', response.data.user.id)

	commit('loadingStatus', null, { root: true })
}

export const deleteNotification = ({ commit, state }, notificationId) => {
	commit('loadingStatus', null, { root: true })

	axios.delete(`${urlBase}/users/${state.user}/notifications/${notificationId}`)
		.then(response => {
			commit('deleteNotification', notificationId)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const markAsRead = ({ state, commit, dispatch }, notificationId) => {
	commit('loadingStatus', null, { root: true })

	axios.put(`${urlBase}/users/${state.user}/notifications/${notificationId}/read`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const markAsUnread = ({ state, commit, dispatch }, notificationId) => {
	commit('loadingStatus', null, { root: true })

	axios.put(`${urlBase}/users/${state.user}/notifications/${notificationId}/unread`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const markAllAsRead = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })

	axios.put(`${urlBase}/users/${state.user}/notifications/read`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const markAllAsUnread = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })

	axios.put(`${urlBase}/users/${state.user}/notifications/unread`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const deleteAllRead = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })

	axios.delete(`${urlBase}/users/${state.user}/notifications/read`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const deleteAllUnread = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })

	axios.delete(`${urlBase}/users/${state.user}/notifications/unread`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}