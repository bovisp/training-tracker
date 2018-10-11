import axios from 'axios'
import store from '../store'

axios.interceptors.response.use(
	response => response,
	error => {
		if (error.response.status === 422) {
			store.dispatch('setErrors', error.response.data.errors)

			store.dispatch('cancelLoadingStatus')
		}

		if (error.response.status === 403) {
			store.dispatch('setErrors', error.response.data.errors.errors)

			store.dispatch('cancelLoadingStatus')
		}

		if (error.response.status === 500) {
			store.dispatch('setErrors', {
				'internal_server_error': [
					'Internal server error'
				]
			})

			store.dispatch('cancelLoadingStatus')
		}

		return Promise.reject(error)
	}
)