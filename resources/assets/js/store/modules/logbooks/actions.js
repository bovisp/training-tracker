export const store = ({ state, commit, dispatch }, payload) => {
	commit('loadingStatus', null, { root: true })

	return axios.post(payload.endpoint, payload.data)
	    .then(response => {
			commit('clearErrors', null, { root: true })

		    dispatch('fetch', payload.endpoint)

		    commit('loadingStatus', null, { root: true })

		    return Promise.resolve(response)
		})
}

export const update = ({ state, commit, dispatch }, payload) => {
	commit('loadingStatus', null, { root: true })

	return axios.put(`/users/${state.userId}/logbooks/${state.logbookId}/entries/${state.entry_id}`, payload)
	    .then(response => {
			commit('clearErrors', null, { root: true })

			commit('updateEntry', response.data.data)

		    commit('loadingStatus', null, { root: true })

		    return Promise.resolve(response)
		})
}

export const destroy = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })

	return axios.delete(`/users/${state.userId}/logbooks/${state.logbookId}/entries/${state.entry_id}`)
	    .then(response => {
			commit('clearErrors', null, { root: true })

			commit('updateEntries', state.entry_id)

			commit('hideEntry')

		    commit('loadingStatus', null, { root: true })

		    return Promise.resolve(response)
		})
}

export const fetch = async ({ commit }, payload) => {
	await commit('loadingStatus', null, { root: true })

	let response = await axios.get(`${payload}/entries`)

	await commit('initialize', response.data.data)

	await commit('loadingStatus', null, { root: true })
}

export const show = async ({ commit }, payload) => {
	await commit('showEntry', payload)
}

export const hide = async ({ commit }) => {
	await commit('hideEntry')
}

export const setLogbookId = async ({ commit }, payload) => {
	await commit('setLogbookId', payload)
}

export const setUserId = async ({ commit }, payload) => {
	await commit('setUserId', payload)
}