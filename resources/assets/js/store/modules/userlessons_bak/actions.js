export const initialize = async ({ commit }, userlesson) => {
	await commit('SET_USERLESSON', userlesson)
}

export const updateForm = ({ commit }, data) => {
	commit('UPDATE_FORM', data)
}

export const update = async ({ state }) => {
	try {
		let response = await axios.put(
			`${urlBase}/users/${state.userlesson.user.id}/userlessons/${state.userlesson.id}`, state.form
		)

		return response
	} catch (e) {
		return e.response
	}
}

export const updateEntry = async ({ state }, { data, entryId}) => {
	try {
		let response = axios.patch(`${urlBase}/entries/${entryId}`, data)

		return response
	} catch (e) {
		return e.response
	}
}

export const destroyEntry = async ({ state }, entryId) => {
	try {
		let response = axios.delete(`${urlBase}/entries/${entryId}`)

		return response
	} catch (e) {
		return e.response
	}
}

export const storeEntry = async({ state, commit, dispatch }, { data, logbookId }) => {
	try {
		let response = axios.post(`${urlBase}/logbooks/${logbookId}/entries`, data)
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