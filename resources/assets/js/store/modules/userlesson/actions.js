export const fetch = async ({ commit }, { userlesson, user }) => {
	await commit('loadingStatus', null, { root: true })

	let response = await axios.get(`${urlBase}/users/${user}/userlessons/${userlesson}/api`)

	console.log(response.data)

	await commit('initialize', response.data)

	if (response.data.completedPackage === 1) {
		window.events.$emit('completedPackage')
	}

	window.events.$emit('allObjectivesCompleted', response.data.userlesson.completedObjectives)

	await commit('loadingStatus', null, { root: true })
}

export const updateStatus = async ({ commit }, payload) => {
	await commit('updateStatus', payload)
}

export const patch = ({ state, commit, dispatch }) => {
	commit('loadingStatus', null, { root: true })
	
	return axios.put(
		`${urlBase}/users/${state.user.id}/userlessons/${state.userlesson.id}`, {
			statuses: state.userlesson.status,
			objectives: state.userlesson.completedObjectives,
			completed: state.completedPackage
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

export const updateCompletedPackage = ({ commit }) => commit('updateCompletedPackage')

export const keepPackageCompleted = ({ commit }) => commit('keepPackageCompleted')