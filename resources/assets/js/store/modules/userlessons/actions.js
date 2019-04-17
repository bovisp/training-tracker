export const fetch = async ({ commit, state }, { userlesson, user }) => {
	try {
		let response = await axios.get(`${urlBase}/api/users/${user}/userlessons/${userlesson}`)

		await commit('SET_COMPLETED_OBJECTIVES', {
			userObjectives: response.data.user.objectives,
			lessonObjectives: response.data.lesson.objectives
		})
		await commit('SET_USERLESSON', response.data)
		await commit('SET_OBJECTIVES', response.data.lesson.objectives)
		await commit('SET_LOGBOOKS', response.data.logbooks)
		await commit('SET_LESSON', response.data.lesson)
		await commit('SET_STATUSES', {
			p9: response.data.p9,
			p18: response.data.p18,
			p30: response.data.p30,
			p42: response.data.p42
		})

		return response
	} catch (e) {
		return e.response
	}
}

export const reset = async ({ commit, state }) => {
	await commit('SET_COMPLETED_OBJECTIVES', {
		userObjectives: state.userlesson.user.objectives,
		lessonObjectives: state.objectives
	})
	await commit('RESET_STATUSES')
}

export const update = async ({ state }) => {
	let statuses = []

	_.forEach(state.form.statuses, status => statuses.push(status))

	try {
		let response = await axios.put(
			`${urlBase}/users/${state.userlesson.user.id}/userlessons/${state.userlesson.id}`, {
				statuses, completedObjectives: state.form.completedObjectives
			}
		)

		return response
	} catch (e) {
		return e.response
	}
}

export const open = async ({ commit, state }, { entryId, logbookId }) => {
	if (logbookId !== null) {
		await commit('TOGGLE_ENTRY_MODAL')
		await commit('SET_LOGBOOK_ID', logbookId)

		return
	}

	try {
		console.log(state.userlesson.user.id)
		let response = await axios.get(`${urlBase}/users/${state.userlesson.user.id}/entries/${entryId}`)

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
		let response = await axios.post(`${urlBase}/users/${state.userlesson.user.id}/logbooks/${logbookId}/entries`, data)

		await dispatch('fetchLogbooks', state.userlesson.id)
		await dispatch('fetchEntry', response.data.entry)
		await commit('SET_LOGBOOK_ID', null)

		return response
	} catch (e) {
		return e.response
	}
}

export const destroyEntry = async ({ state, dispatch }, entryId) => {
	try {
		let response = axios.delete(`${urlBase}/users/${state.userlesson.user.id}/entries/${entryId}`)

		await dispatch('close')
		await dispatch('fetchLogbooks', state.userlesson.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const updateEntry = async ({ state, dispatch }, data) => {
	try {
		let response = axios.patch(`${urlBase}/users/${state.userlesson.user.id}/entries/${state.entry.id}`, data)

		await dispatch('fetchLogbooks', state.userlesson.id)
		await dispatch('fetchEntry', state.entry.id)

		return response
	} catch (e) {
		return e.response
	}
}

export const fetchLogbooks = async ({ commit, state }, userlessonId) => {
	let response = await axios.get(`${urlBase}/users/${state.userlesson.user.id}/userlessons/${userlessonId}/logbooks`)

	await commit('SET_LOGBOOKS', response.data.logbooks)
}

export const fetchEntry = async ({ commit, state }, entryId) => {
	let response = await axios.get(`${urlBase}/users/${state.userlesson.user.id}/entries/${entryId}`)

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

export const updateStatus = async ({ commit }, {period, value}) => {
	await commit('UPDATE_STATUS', {period, value})
}