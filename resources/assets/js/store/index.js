import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

 const state = {
	userlesson: {},
	user: {},
	isLoading: true
}

const mutations = {
	initializeUserLesson (state, payload) {
		state.userlesson = payload
	},

	initializeUser (state, payload) {
		state.user = payload
	},

	updateP9 (state, payload) {
		state.userlesson.status.p9 = payload
	},

	updateP18 (state, payload) {
		state.userlesson.status.p18 = payload
	},

	updateP30 (state, payload) {
		state.userlesson.status.p30 = payload
	},

	updateP42 (state, payload) {
		state.userlesson.status.p42 = payload
	},

	loadStatus (state, payload) {
		state.isLoading = payload
	}
}

const actions = {
	loadState({ commit }, { userlesson, user }) {
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
		
	},

	updateLessonPackage({ state, commit }, payload) {
		commit('loadStatus', true)
		
		axios.interceptors.response.use(
            response => {
              return response;
            },
            error => {
                return Promise.reject(error.response);
            }
        )

		return axios.put(
			`/users/${state.user.id}/userlessons/${state.userlesson.id}`,
			payload
		)
	}
}

export default new Vuex.Store({ state, mutations, actions })