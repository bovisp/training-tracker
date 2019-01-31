<template>
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
</template>

<script>
	import CurrentDeactivation from './CurrentDeactivation'
	import ManageDeactivations from './ManageDeactivations'

	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		},

		components: {
			CurrentDeactivation,
			ManageDeactivations
		}
	}
</script>