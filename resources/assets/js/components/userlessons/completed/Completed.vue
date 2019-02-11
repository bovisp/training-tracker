<template>
	<b-checkbox v-model="completed"
	    type="is-success"
	    :disabled="!hasRoleOf(['supervisor', 'head_of_operations'])"
	    true-value="1"
	    false-value="0"
	>This lesson package has been successfully completed</b-checkbox>
</template>

<script>
	export default {
		data () {
			return {
				completed: 0
			}
		},

		watch: {
			completed () {
				this.$emit('updatecompleted',this.completed)
			}
		},

		mounted () {
			window.events.$on('completed', ({ completed }) => {
				this.completed = completed
			})

			window.events.$on('removecompletion', () => this.completed = 0)
		}
	}
</script>