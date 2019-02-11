export const initialize = (state, payload) => {
	state.userlesson = payload.userlesson
	state.user = payload.user
	state.auth = payload.auth
	state.completedPackage = payload.completedPackage
}

export const updateStatus = (state, payload) => state.userlesson.status[payload.status] = payload.event.target.value

export const updateCompletedObjectives = (state, payload) => state.userlesson.completedObjectives = payload

export const updateCompletedPackage = state => {
	if (state.completedPackage === 0) {
		state.completedPackage = 1

		return
	}

	state.completedPackage = 0
}