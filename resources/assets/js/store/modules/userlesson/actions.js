export const fetch = async ({ commit }, { userlesson, user }) => {
	await commit('loadingStatus')

	let response = await axios.get(`/users/${user}/userlessons/${userlesson}/api`)

	await commit('initialize', response.data)

	await commit('loadingStatus')
}

export const updateStatus = async ({ commit }, payload) => {
	await commit('updateStatus', payload)
}

export const patch = async ({ state, commit, dispatch }) => {
	await commit('loadingStatus')
	
	axios.interceptors.response.use(
        response => {
          return response;
        },
        error => {
            return Promise.reject(error.response);
        }
    )

	try {
		let response = await axios.put(
			`/users/${state.user.id}/userlessons/${state.userlesson.id}`, {
				statuses: state.userlesson.status,
				objectives: state.userlesson.completedObjectives
			}
	    )

	    await commit('clearErrors')

	    await dispatch('fetch', {
	    	userlesson: state.userlesson.id,
	    	user: state.user.id
	    })

	    await commit('loadingStatus')

	    window.events.$emit('userlesson:save-success', response.data.flash)
	} catch(error) {
		if (error) {
			await commit('setErrors', error.data.errors)

			await commit('loadingStatus')
		}
	}
}