<template>
	<li class="mb-4">
		<article class="media">
			<div class="media-content">
				<div class="content mb-2">
					<p>
						<strong>{{ comment.user.firstname }} {{ comment.user.lastname }}</strong> 

						<span class="has-text-grey">
							<small>added this on: {{ comment.created_at }}</small>

							<small v-if="comment.edited"> | edited: {{ comment.edited }}</small>
						</span>

						<br>

						<template v-if="!editing">
							{{ comment.body }}
						</template>

						<template v-else>
							<comment-edit :comment="comment" :endpoint="endpoint" />
						</template>
					</p>
				</div>

				<template v-if="comment.owner && !editing">
					<div class="level">
						<div class="level-left">
							<div class="level-item">
								<button
									class="button is-text is-small"
									@click.prevent="editing = true"
								>Edit</button>
							</div>

							<div class="level-item" v-if="hasRoleOf('administrator')">
								<button
									class="button is-text is-small has-text-danger"
									@click.prevent="confirm"
								>Delete</button>
							</div>
						</div>
					</div>
				</template>
			</div>
		</article>
	</li>
</template>

<script>
	import CommentEdit from './CommentEdit'
	import { mapActions, mapGetters } from 'vuex'

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

		components: {
			CommentEdit
		},

		data () {
			return { 
				editing: false
			}
		},

		computed: {
			...mapGetters({
				errors: 'errors'
			})
		},

		methods: {
			...mapActions({
				destroy: 'comments/destroy'
			}),

			confirm () {
                this.$dialog.confirm({
                    message: 'Are you sure you want to delete this comment?',
                    onConfirm: () => this.remove()
                })
			},

			remove () {
				this.destroy(`${this.endpoint}/${this.comment.id}`)
					.then(response => {
						this.$toast.open({
			                message: 'Comment successfully deleted.',
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
		},

		mounted () {
			window.events.$on('comment:edit-cancelled', (comment) => {
				if (comment.id === this.comment.id) {
					this.editing = false
				}
			})
		}
	}
</script>