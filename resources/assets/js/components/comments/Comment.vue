<template>
	<li class="mb-4">
		<article class="media" :id="commentId">
			<div class="media-content">
				<div class="content mb-2">
					<p>
						<strong>{{ comment.user.firstname }} {{ comment.user.lastname }}</strong> 

						<span class="has-text-grey">
							<small>{{ trans('app.components.comments.addedon') }} {{ comment.created_at }}</small>

							<small v-if="comment.edited"> | {{ trans('app.components.comments.edited') }} {{ comment.edited }}</small>
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

				<template v-if="canEdit && !editing && !isCompleted">
					<div class="level">
						<div class="level-left">
							<div class="level-item">
								<button
									class="button is-text is-small"
									@click.prevent="editing = true"
								>{{ trans('app.general.buttons.edit') }}</button>
							</div>

							<div class="level-item">
								<button
									class="button is-text is-small has-text-danger"
									@click.prevent="confirm"
								>{{ trans('app.general.buttons.delete') }}</button>
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
			},
			isCompleted: {
				required: false,
				type: Boolean,
				default: false
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
			}),

			commentId () {
				return `comment-${this.comment.id}`
			},

			canEdit () {
				return (this.authUser.id == this.comment.user.id) || 
					(
						this.authUser.rank < this.comment.user.roleRank && 
						this.authUser.role !== 'manager' &&
						this.authUser.role !== 'head_of_operations'
					)
			}
		},

		methods: {
			...mapActions({
				destroy: 'comments/destroy'
			}),

			confirm () {
                this.$buefy.dialog.confirm({
                    message: this.trans('app.components.comments.deletecomment'),
                    onConfirm: () => this.remove()
                })
			},

			remove () {
				this.destroy(`${this.endpoint}/${this.comment.id}`)
					.then(response => {
						this.$buefy.toast.open({
			                message: this.trans('app.components.comments.commentdeleted'),
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