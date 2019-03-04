export const fetch = async ({ commit }, userlessonId) => {
	try {
		let response = await axios.get(`/api/userlessons/${userlessonId}`)

		await commit('SET_USERLESSON', response.data)
		await commit('SET_OBJECTIVES', response.data.lesson.objectives)
		await commit('SET_COMPLETED_OBJECTIVES', response.data.user.objectives)
		await commit('SET_LOGBOOKS', response.data.logbooks)
		await commit('SET_LESSON', response.data.lesson)

		return response
	} catch (e) {
		return e.response
	}
}

export const open = async ({ commit }, { entryId, logbookId }) => {
	if (logbookId !== null) {
		await commit('TOGGLE_ENTRY_MODAL')
		await commit('SET_LOGBOOK_ID', logbookId)

		return
	}

	try {
		let response = await axios.get(`${urlBase}/entries/${entryId}`)

		await commit('TOGGLE_ENTRY_MODAL')
		await commit('SET_ENTRY', response.data.data)

		return response
	} catch (e) {
		return e.response
	}
}

export const close = async ({ commit, state, dispatch }) => {
	await commit('TOGGLE_ENTRY_MODAL')
	await commit('SET_ENTRY', {})
	await commit('comments/setComments', {}, { root: true })
	await dispatch('comments/fetch', `/users/${state.userlesson.user.id}/userlessons/${state.userlesson.id}/comments`, { root: true })
	await commit('SET_LOGBOOK_ID', null)
}

export const storeEntry = async ({ state, commit, dispatch }, { data, logbookId }) => {
	try {
		let response = await axios.post(`${urlBase}/logbooks/${logbookId}/entries`, data)

		await dispatch('fetchLogbooks', state.userlesson.id)
		await dispatch('fetchEntry', response.data.entry)
		await commit('SET_LOGBOOK_ID', null)

		return response
	} catch (e) {
		return e.response
	}
}

export const fetchLogbooks = async ({ commit }, userlessonId) => {
	let response = await axios.get(`${urlBase}/userlessons/${userlessonId}/logbooks`)

	await commit('SET_LOGBOOKS', response.data.logbooks)
}

export const fetchEntry = async ({ commit }, entryId) => {
	let response = await axios.get(`${urlBase}/entries/${entryId}`)

	await commit('SET_ENTRY', response.data.data)
}

export const deleteFile = async ({ commit, state }, payload) => {
	try {
		let response = await axios.delete(`${urlBase}/storage/entries/${state.userlesson.user.id}/${state.entry.id}/${payload}`)

		await commit('DELETE_FILE', payload)

		return response
	} catch (e) {
		return e.response
	}
}

export const patchFiles = async ({ commit, state }, payload) => {
	try {
		let response = await axios.patch(`${urlBase}/storage/entries/${state.userlesson.user.id}/${state.entry.id}/updatefiles`, payload)

		await commit('UPDATE_FILES', payload)

		return response
	} catch (e) {
		return e.response
	}
}