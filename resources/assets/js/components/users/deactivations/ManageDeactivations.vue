<template>
	<div>
		<button 
			class="button is-text is-small"
			@click.prevent="active"
		>Manage deactivations</button>

		<deactivations-modal 
			:user="user"
		/>
	</div>
</template>

<script>
	import DeactivationsModal from './DeactivationsModal'

	export default {
		props: {
			user: {
				required: true,
				type: Object
			}
		},

		components: {
			DeactivationsModal
		},

		methods: {
			active () {
				window.events.$emit('deactivation-model:toggle')
			}
		}
	}
</script>