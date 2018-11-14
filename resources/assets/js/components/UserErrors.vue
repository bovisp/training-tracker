<template>
	<div class="message is-danger" v-if="Object.keys(errors).length">
		<div class="message-body">
			<div class="content">
				<ul class="mt-0">
					<template v-for="error in Object.keys(errors)">
						<li v-text="errors[error][0]"></li>
					</template>
				</ul>
			</div>
		</div>
	</div>
	
</template>

<script>
	export default {
		data () {
			return  {
				errors: {}
			}
		},

		mounted () {
			window.events.$on('users-create-error', (errors) => {
				this.errors = errors;
			})
		}
	}
</script>