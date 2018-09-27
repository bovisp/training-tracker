<template>
	<form>
		<div class="field">
			<div class="control">
				<textarea
					:rows="textareaHeight"
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

		<div class="field is-grouped">
			<div class="control">
				<button 
					class="button is-link is-small" 
					type="submit"
					@click.prevent="submit"
				>Edit</button>
			</div>

			<div class="control">
				<button 
					class="button is-text is-small"
					@click.prevent="cancel"
				>Cancel</button>
			</div>
		</div>
	</form>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {
		props: {
			comment: {
				required: true,
				type: Object
			},
			endpoint: {
				required: true,
				type: String
			}
		},

		data () {
			return {
				form: {
					body: this.comment.body
				}
			}
		},

		computed: {
			...mapGetters({
				errors: 'errors'
			}),

			textareaHeight () {
				return Math.max(
					Math.floor(this.comment.body.split(/\r*\n/).length / 2),
					6
				)
			}
		},

		methods: {
			...mapActions({
				patch: 'comments/patch'
			}),

			cancel () {
				window.events.$emit('comment:edit-cancelled', this.comment)
			},

			submit () {
				this.patch({
					endpoint: `${this.endpoint}/${this.comment.id}`,
					data: this.form
				})
					.then(response => {
						this.cancel()

						this.$toast.open({
			                message: 'Comment successfully updated.',
			                position: 'is-top-right',
			                type: 'is-success'
	            		})
					}).catch(error => {
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