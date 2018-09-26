export const setErrors = (state, payload) => state.errors = payload

export const clearErrors = state => state.errors = {}

export const loadingStatus = state => state.isLoading = !state.isLoading
