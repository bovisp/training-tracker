export const entries = state => state.entries

export const entry = state => _.find(state.entries, { id: state.entry_id })

export const entryId = state => state.entry_id

export const logbookId = state => state.logbookId

export const userId = state => state.userId