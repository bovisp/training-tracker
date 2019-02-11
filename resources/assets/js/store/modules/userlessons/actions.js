export const initialize = async ({ commit }, userlesson) => {
	await commit('SET_USERLESSON', userlesson)
}

export const updateForm = ({ commit }, data) => {
	commit('UPDATE_FORM', data)
}

export const update = async ({ commit, state, dispatch }) => {
	try {
		let response = await axios.put(
			`${urlBase}/users/${state.userlesson.user.id}/userlessons/${state.userlesson.id}`, state.form
		)

		return response
	} catch (e) {
		return e.response
	}
}