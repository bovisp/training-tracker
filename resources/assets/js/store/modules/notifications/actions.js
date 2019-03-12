export const fetch = async ({ commit }, user) => {
	try {
		let response = await axios.get(`${urlBase}/users/${user}/notifications/api`)

		await commit('SET_USER', response.data.user)
		await commit('SET_UNREAD', response.data.notifications)
    await commit('SET_READ', response.data.notifications)
    await commit('SET_APPRENTICE_NAMES', response.data.notifications)

		return response
	} catch (e) {
		return e.response
	}
}

export const fetchEntry = async ({ commit, state, dispatch }, { entryId, userId, userlessonId }) => {
	let response = await axios.get(`${urlBase}/users/${userId}/entries/${entryId}`)

	await commit('userlessons/SET_ENTRY', response.data.data, {root: true})

	await dispatch('userlessons/fetch', {userlesson: userlessonId, user: userId}, {root: true})
}

export const close = async ({ commit }) => {
	await commit('userlessons/SET_ENTRY', {}, { root: true })
	await commit('comments/setComments', {}, { root: true })
}

export const deleteNotification = async ({ commit, dispatch, state }, notificationId) => {
	try {
		let response = await axios.delete(`${urlBase}/users/${state.user.id}/notifications/${notificationId}`)

		await commit('DELETE_NOTIFICATION', notificationId)
		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const markAsRead = async ({ state, commit, dispatch }, notificationId) => {
	try {
		let response = await axios.put(`${urlBase}/users/${state.user.id}/notifications/${notificationId}/read`)

		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const markAsUnread = async ({ state, commit, dispatch }, notificationId) => {
	try {
		let response = await axios.put(`${urlBase}/users/${state.user.id}/notifications/${notificationId}/unread`)

		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const markAllAsRead = async ({ state, commit, dispatch }) => {
	try {
		let response = await axios.put(`${urlBase}/users/${state.user.id}/notifications/read`)

		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const deleteAllUnread = async ({ state, commit, dispatch }) => {
	try {
		let response = await axios.delete(`${urlBase}/users/${state.user.id}/notifications/unread`)

		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const markAllAsUnread = async ({ state, commit, dispatch }) => {
	try {
		let response = await axios.put(`${urlBase}/users/${state.user.id}/notifications/unread`)

		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const deleteAllRead = async ({ state, commit, dispatch }) => {
	try {
		let response = await axios.delete(`${urlBase}/users/${state.user.id}/notifications/read`)

		await dispatch('fetch', state.user.id)

		return response
	} catch (e) {
		return e.response
	}
}