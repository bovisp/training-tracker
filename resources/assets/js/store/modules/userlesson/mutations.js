export function initializeUserLesson (state, payload) {
	state.userlesson = payload
}

export function initializeUser (state, payload) {
	state.user = payload
}

export function loadStatus (state, payload) {
	state.isLoading = payload
}

export function updateP9 (state, payload) {
	state.userlesson.status.p9 = payload
}

export function updateP18 (state, payload) {
	state.userlesson.status.p18 = payload
}

export function updateP30 (state, payload) {
	state.userlesson.status.p30 = payload
}

export function updateP42 (state, payload) {
	state.userlesson.status.p42 = payload
}

export function updateCompletedObjectives (state, payload) {
	state.userlesson.completedObjectives = payload
}