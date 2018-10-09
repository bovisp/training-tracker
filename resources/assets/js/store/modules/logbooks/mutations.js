export const initialize = (state, payload) => state.entries = payload

export const showEntry = (state, payload) => state.entry_id = payload

export const hideEntry = (state, payload) => state.entry_id = null

export const updateEntry = (state, payload) => {
	_.assign(_.find(state.entries, { id: payload.id }), payload)
}

export const updateEntries = (state, payload) => {
	state.entries = state.entries.filter(entry => entry.id !== payload)
}

export const deleteFile = (state, payload) => {
	let entry = _.find(state.entries, { id: state.entry_id })

	entry.files = entry.files.filter(file => file.codedFilename !== payload)

	_.assign(_.find(state.entries, { id: state.entry_id }), entry)
}

export const updateFiles = async (state, payload) => {
	let entry = await _.find(state.entries, { id: state.entry_id })

	await _.forEach(payload.files, file => {
		entry.files.push(file)
	})

	_.assign(_.find(state.entries, { id: state.entry_id }), entry)
}

export const setLogbookId = (state, payload) => state.logbookId = payload

export const setUserId = (state, payload) => state.userId = payload