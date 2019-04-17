<template>
	<div class="mb-6">
		<button 
			class="button is-text has-text-info"
			@click.prevent="markAsActive"
			v-if="!active"
		>{{ trans('app.components.comments.addcomment') }}</button>

		<template v-else>
			<form>
				<div class="field">
					<label for="body" class="label">{{ trans('app.components.comments.comment') }}</label>

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
					>{{ trans('app.general.buttons.submit') }}</button>

					<button 
						class="button is-text is-small"
						@click.prevent="markAsInactive"
					>{{ trans('app.general.buttons.cancel') }}</button>
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

			markAsActive () {
				this.active = true

				window.events.$emit('comment:new-active')
			},

			markAsInactive () {
				this.active = false

				window.events.$emit('comment:new-inactive')
				window.events.$emit('comment:saved')
			},

			submit () {
				this.store({
					endpoint: this.endpoint,
					data: this.form
				})
				.then(response => {
					this.markAsInactive()

					this.form.body = ''

					this.$toast.open({
		                message: this.trans('app.components.comments.commentadded'),
		                position: 'is-top-right',
		                type: 'is-success'
            		})
				})
				.catch(error => {
					if (error.response.status === 403) {
						this.$dialog.alert({
		                    title: this.trans('app.general.unauthorized'),
		                    message: this.errors.denied,
		                    type: 'is-danger'
		                })

		                this.markAsInactive()
					}
				})
			}
		}
	}
</script>