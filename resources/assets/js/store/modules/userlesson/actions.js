export const fetch = async ({ commit }, { userlesson, user }) => {
	await commit('loadingStatus', null, { root: true })

	let response = await axios.get(`/users/${user}/userlessons/${userlesson}/api`)

	await commit('initialize', response.data)

	await commit('loadingStatus', null, { root: true })
}

export const updateStatus = async ({ commit }, payload) => {
	await commit('updateStatus', payload)
}

export const patch = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })
	
	return axios.put(
		`/users/${state.user.id}/userlessons/${state.userlesson.id}`, {
			statuses: state.userlesson.status,
			objectives: state.userlesson.completedObjectives,
			// objectives: ['foo', 'bar', 'baz']
		}
    )
    .then(response => {
		commit('clearErrors', null, { root: true })

	    dispatch('fetch', {
	    	userlesson: state.userlesson.id,
	    	user: state.user.id
	    })

	    commit('loadingStatus', null, { root: true })

	    return Promise.resolve(response)
	})
}