export function loadState({ commit }, { userlesson, user }) {
	commit('loadStatus', true)

	return axios.get(`/users/${user}/userlessons/${userlesson}/api`)
		.then(({data}) => {
			return new Promise((resolve, reject) => {
				commit('initializeUserLesson', data.userlesson)
				commit('initializeUser', data.user)
				resolve()
			})
		})
		.then(() => {
			return new Promise((resolve, reject) => {
				commit('loadStatus', false)
				resolve()
			})
		})
	
}

export function updateLessonPackage({ state, commit }) {
	commit('loadStatus', true)
	
	axios.interceptors.response.use(
        response => {
          return response;
        },
        error => {
        	commit('loadStatus', false)
            return Promise.reject(error.response);
        }
    )

	return axios.put(
		`/users/${state.user.id}/userlessons/${state.userlesson.id}`,
		{statuses: state.userlesson.status}
	)
}