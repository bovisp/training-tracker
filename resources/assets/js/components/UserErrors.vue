<template>
	<div class="message is-danger" v-if="Object.keys(errors_data).length">
		<div class="message-body">
			<div class="content">
				<ul class="mt-0">
					<template v-for="error in Object.keys(errors_data)">
						<li v-text="errors_data[error][0]"></li>
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
				errors_data: {}
			}
		},

		mounted () {
			window.events.$on('users-create-error', (errors) => {
				this.errors_data = errors;
			})
		}
	}
</script>