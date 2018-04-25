<template>
	<div class="message is-danger" v-if="errors.length">
		<div class="message-body">
			<div class="content">
				<ul class="mt-0">
					<template v-for="error in errors">
						<li v-if="error.errors.role" v-text="error.errors.role[0]"></li>
						<li v-if="error.errors.id" v-text="error.errors.id[0]"></li>
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
				errors: []
			}
		},

		mounted () {
			window.events.$on('users-create-error', (errors) => {
				this.errors = errors.slice(0, errors.length / 2);
			})
		}
	}
</script>