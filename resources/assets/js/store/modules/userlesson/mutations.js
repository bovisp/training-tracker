export const initialize = (state, payload) => {
	state.userlesson = payload.userlesson
	state.user = payload.user
	state.auth = payload.auth
}

export const loadingStatus = state => state.isLoading = !state.isLoading

export const updateStatus = (state, payload) => state.userlesson.status[payload.status] = payload.event.target.value

export const updateCompletedObjectives = (state, payload) => state.userlesson.completedObjectives = payload

export const setErrors = (state, payload) => state.errors = payload

export const clearErrors = (state) => state.errors = {
	p9: [],
	p18: [],
	p30: [],
	p42: [],
	objectives: []
}