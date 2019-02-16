export const SET_USERLESSON = (state, userlesson) => state.userlesson = userlesson

export const UPDATE_FORM = (state, data) => state.form = data

export const SET_LOGBOOKS = (state, logbooks) => state.logbooks = logbooks

export const SET_ENTRY = (state, entry) => state.entry = entry

export const DELETE_FILE = (state, payload) => {
	state.entry.files = filter(state.entry.files, file => file.codedFilename !== payload)
}

export const UPDATE_FILES = (state, payload) => {
	forEach(payload.files, file => state.entry.files.push(file))
}