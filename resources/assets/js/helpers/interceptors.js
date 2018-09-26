import axios from 'axios'
import store from '../store'

axios.interceptors.response.use(
	response => response,
	error => {
		if (error.response.status === 422) {
			store.dispatch('setErrors', error.response.data.errors)

			store.dispatch('loadingStatus')
		}

		if (error.response.status === 403) {
			store.dispatch('setErrors', error.response.data.errors.errors)

			store.dispatch('loadingStatus')
		}

		return Promise.reject(error)
	}
)