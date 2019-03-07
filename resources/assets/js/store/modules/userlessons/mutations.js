export const SET_USERLESSON = (state, userlesson) => state.userlesson = userlesson

export const SET_OBJECTIVES = (state, objectives) => state.objectives = objectives

export const SET_LOGBOOKS = (state, logbooks) => state.logbooks = logbooks

export const SET_ENTRY = (state, entry) => state.entry = entry

export const SET_LESSON = (state, lesson) => state.lesson = lesson

export const SET_COMPLETED_OBJECTIVES = (state, completedObjectives) => {
	state.form.completedObjectives = _.map(completedObjectives, objective => objective.id)

	state.allObjectivesComplete = state.form.completedObjectives.length === state.objectives.length
}

export const SET_STATUSES = (state, statuses) => {
	state.form.statuses.p9 = statuses.p9
	state.form.statuses.p18 = statuses.p18
	state.form.statuses.p30 = statuses.p30
	state.form.statuses.p42 = statuses.p42

	_.forEach(statuses, status => {
		if (status === 'c') {
			state.statusComplete = true
		}
	})
}

export const UPDATE_STATUS = (state, {period, value}) => {
	state.form.statuses[period] = value

	if (value === 'c') {
		state.statusComplete = true
	} else {
		state.statusComplete = false
	}
}

export const RESET_STATUSES = (state) => {
  for (const status in state.form.statuses) {
    if (state.form.statuses[status] === 'c') {
		state.form.statuses[status] = null
		state.statusComplete = false
	}
  }
}

export const UPDATE_COMPLETED_OBJECTIVES = (state, completedObjectives) => {
	state.form.completedObjectives = completedObjectives

	state.allObjectivesComplete = state.form.completedObjectives.length === state.objectives.length
}

export const TOGGLE_ENTRY_MODAL = state => state.entryModalActive = !state.entryModalActive

export const SET_LOGBOOK_ID = (state, logbookId) => state.logbookId = logbookId

export const DELETE_FILE = (state, payload) => {
	state.entry.files = filter(state.entry.files, file => file.codedFilename !== payload)
}

export const UPDATE_FILES = (state, payload) => {
	forEach(payload.files, file => state.entry.files.push(file))
}

export const UPDATE_LOADING = state => state.isLoading = !state.isLoading