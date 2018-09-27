<template>
	<div class="mb-6">
		<button 
			class="button is-link is-small"
			@click.prevent="active = true"
			v-if="!active"
		>Add new comment</button>

		<template v-else>
			<form>
				<div class="field">
					<label for="body" class="label">Comment</label>

					<div class="control">
						<textarea
							id="body"
							rows="10"
							class="textarea"
							:class="{ 'is-danger': errors.body }"
							autofocus="autofocus"
							v-model="form.body"
						></textarea>
					</div>

					<p class="help is-danger" v-if="errors.body">
						{{ errors.body[0] }}
					</p>
				</div>

				<div class="form-group">
					<button 
						class="button is-link is-small" 
						@click.prevent="submit"
					>Submit</button>

					<button 
						class="button is-text is-small"
						@click.prevent="active = false"
					>Cancel</button>
				</div>
			</form>
		</template>
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			}
		},

		data () {
			return {
				form: {
					body: ''
				},
				active: false
			}
		},

		computed: {
			...mapGetters({
				errors: 'errors'
			})
		},

		methods: {
			...mapActions({
				store: 'comments/store'
			}),

			submit () {
				this.store({
					endpoint: this.endpoint,
					data: this.form
				})
				.then(response => {
					this.active = false

					this.form.body = ''

					this.$toast.open({
		                message: 'Comment successfully added.',
		                position: 'is-top-right',
		                type: 'is-success'
            		})
				})
				.catch(error => {
					if (error.response.status === 403) {
						this.$dialog.alert({
		                    title: 'Unauthorized',
		                    message: this.errors.denied,
		                    type: 'is-danger'
		                })
					}
				})
			}
		}
	}
</script>