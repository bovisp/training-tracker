export const initialize = (state, payload) => {
	state.userlesson = payload.userlesson
	state.user = payload.user
	state.auth = payload.auth
}

export const updateStatus = (state, payload) => state.userlesson.status[payload.status] = payload.event.target.value

export const updateCompletedObjectives = (state, payload) => state.userlesson.completedObjectives = payload