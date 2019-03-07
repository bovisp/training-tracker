<template>
	<div>
		<dt>
			<strong>{{ !user.active ?  'Current deactivation' : 'Deactivations' }}</strong>
		</dt>

		<dd>
			<div v-if="!user.active" class="mb-4">
				<current-deactivation 
					:user="user"
				/>
			</div>

			<manage-deactivations
				v-if="user.deactivations.length"
				:user="user"
			/>
		</dd>
	</div>
</template>

<script>
	import CurrentDeactivation from './CurrentDeactivation'
	import ManageDeactivations from './ManageDeactivations'

	export default {
		props: {
			userInit: {
				type: Object,
				required: true
			}
		},

		data () {
			return {
				user: this.userInit
			}
		},

		components: {
			CurrentDeactivation,
			ManageDeactivations
		},

		mounted () {
			window.events.$on('user:activation', status => {
				console.log(status)
				this.user.active = status
			})
		}
	}
</script>