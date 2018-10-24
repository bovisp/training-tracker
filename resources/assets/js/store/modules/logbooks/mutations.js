export const initialize = (state, payload) => state.entries = payload

export const showEntry = (state, payload) => state.entry_id = payload

export const hideEntry = (state, payload) => state.entry_id = null

export const updateEntry = (state, payload) => {
	assign(find(state.entries, { id: payload.id }), payload)
}

export const updateEntries = (state, payload) => {
	state.entries = filter(state.entries, entry => entry.id !== payload)
}

export const deleteFile = (state, payload) => {
	let entry = find(state.entries, { id: state.entry_id })

	entry.files = filter(entry.files, file => file.codedFilename !== payload)

	assign(find(state.entries, { id: state.entry_id }), entry)
}

export const updateFiles = async (state, payload) => {
	let entry = await find(state.entries, { id: state.entry_id })

	await forEach(payload.files, file => entry.files.push(file))

	assign(find(state.entries, { id: state.entry_id }), entry)
}

export const setLogbookId = (state, payload) => state.logbookId = payload

export const setUserId = (state, payload) => state.userId = payload