export const SET_USERLESSON = (state, userlesson) => state.userlesson = userlesson

export const SET_OBJECTIVES = (state, objectives) => state.objectives = objectives

export const SET_LOGBOOKS = (state, logbooks) => state.logbooks = logbooks

export const SET_ENTRY = (state, entry) => state.entry = entry

export const SET_LESSON = (state, lesson) => state.lesson = lesson

export const SET_COMPLETED_OBJECTIVES = (state, completedObjectives) => {
	state.form.completedObjectives = _.map(completedObjectives, objective => objective.id)

	state.allObjectivesComplete = state.form.completedObjectives.length === state.objectives.length
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