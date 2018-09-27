<template>
	<div>
		<!-- <template v-if="reply">
			<comment-reply :comment="reply" />
		</template> -->

		<!-- <template v-else> -->
		<!-- <h5 class="mb-5">{{ meta.total }} {{ pluralize('comment', meta.total) }}</h5> -->

		<new-comment 
			:endpoint="endpoint" 
			v-if="hasRoleOf('supervisor', 'head_of_operations')"
		/>

		<template v-if="comments.length">
			<ul>
				<comment 
					v-for="comment in comments"
					:key="comment.id"
					:comment="comment"
					:endpoint="endpoint"
				/>
			</ul>
		</template>

		<!-- <div 
			class="alert alert-primary" 
			role="alert"
			v-else
		>No comments to display</div>

		<button 
			class="btn btn-light btn-block"
			@click.prevent="more"
			v-if="meta.current_page < meta.last_page"
		>Show more</button> -->
		<!-- </template> -->
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Comment from './Comment'
	import NewComment from './NewComment'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			}
		},

		components: {
			Comment,
			NewComment
		},

		computed: {
			...mapGetters({
				comments: 'comments/comments'
			})
		},

		methods: {
			...mapActions({
				fetch: 'comments/fetch'
			})
		},

		mounted () {
			this.fetch(this.endpoint)
		}
	}
</script>