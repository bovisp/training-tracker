export const fetch = async ({ commit }, userId) => {
	commit('loadingStatus', null, { root: true })

	let response = await axios.get(`/users/${userId}/notifications/api`)

	await commit('setUnreadNotifications', response.data.notifications)

	await commit('setReadNotifications', response.data.notifications)

	await commit('setUser', response.data.user.id)

	commit('loadingStatus', null, { root: true })
}

export const deleteNotification = ({ commit, state }, notificationId) => {
	commit('loadingStatus', null, { root: true })

	axios.delete(`/users/${state.user}/notifications/${notificationId}`)
		.then(response => {
			commit('deleteNotification', notificationId)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const markAsRead = ({ state, commit, dispatch }, notificationId) => {
	commit('loadingStatus', null, { root: true })

	axios.put(`/users/${state.user}/notifications/${notificationId}`)
		.then(response => {
			dispatch('fetch', state.user)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}