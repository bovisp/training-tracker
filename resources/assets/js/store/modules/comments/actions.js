export const fetch = async ({ commit }, endpoint) => {
	let response = await axios.get(endpoint)

	await commit('setComments', response.data.data)
}

export const store = ({ commit }, { endpoint, data }) => {
	commit('loadingStatus', null, { root: true })

	return axios.post(endpoint, data)
		.then(response => {
			commit('clearErrors', null, { root: true })

			commit('addComment', response.data.data)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const patch = ({ commit }, { endpoint, data }) => {
	commit('loadingStatus', null, { root: true })

	return axios.put(endpoint, data)
		.then(response => {
			commit('clearErrors', null, { root: true })

			commit('updateComment', response.data.data)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}

export const destroy = ({ commit }, endpoint) => {
	commit('loadingStatus', null, { root: true })

	return axios.delete(endpoint)
		.then(response => {
			commit('clearErrors', null, { root: true })

			commit('deleteComment', response.data.data)

			commit('loadingStatus', null, { root: true })

			return Promise.resolve(response)
		})
}