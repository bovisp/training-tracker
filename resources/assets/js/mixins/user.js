export default {
	data () {
		return {
			authUser: window.User
		}
	},

	methods: {
		hasRoleOf(...roles) {
			if (this.authUser.role === 'administrator') {
				return true
			}
			
			return roles.indexOf(this.authUser.role) > -1
		}
	}
}