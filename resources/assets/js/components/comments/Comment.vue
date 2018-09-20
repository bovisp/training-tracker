<template>
	<div class="card">
		<div class="card-content">
			<p class="title is-5">
				{{ fullname }}
			</p>
			<p class="subtitle is-6 has-text-grey">
				{{ role }}
			</p>
		
			
			<template v-if="!editing">
				<div class="content">
					<p>{{ comment.body }}</p>

					<small class="has-text-grey is-size-7">
						{{ comment.created_at }}
					</small>
				</div>
			</template>

			<template v-else>
				<comment-edit :comment="comment" />
			</template>

			<ul 
				v-if="canEdit && !editing"
				class="is-flex"
			>
				<li>
					<button 
						class="button is-info is-small mr-4"
						@click.prevent="editing = true"
					>
						Edit
					</button>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import CommentEdit from './CommentEdit'

	export default {
		props: ['comment'],

		data () {
			return {
				editing: false
			}
		},

		components: {
			CommentEdit
		},

		computed: {
			fullname () {
				return this.comment.user.profile[0].firstname + ' ' + this.comment.user.profile[0].lastname
			},

			role () {
				return this.comment.user.role
			},

			canEdit() {
				return (this.authUser.role === 'administrator') || (this.comment.user.id == this.authUser.id)
			}
		},

		mounted () {
			window.events.$on('comment:edit-cancelled', comment => {

			})
		}
	}
</script>