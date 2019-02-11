export const setErrors = ({ commit }, payload) => commit('setErrors', payload)

export const clearErrors = ({ commit }) => commit('clearErrors')

export const loadingStatus = ({ commit }) => commit('loadingStatus')

export const cancelLoadingStatus = ({ commit }) => commit('cancelLoadingStatus')