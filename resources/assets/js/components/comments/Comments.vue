<template>
	<div>
		<new-comment 
			:endpoint="endpoint" 
			v-if="hasRoleOf(createRoles) && !isCompleted"
		/>

		<template v-if="comments.length">
			<ul>
				<comment 
					v-for="comment in comments"
					:key="comment.id"
					:comment="comment"
					:endpoint="endpoint"
					:is-completed="isCompleted"
				/>
			</ul>
		</template>

		<article class="message is-info" v-else>
			<div class="message-body">
				No comments to display
			</div>
		</article>
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Comment from './Comment'
	import NewComment from './NewComment'
	import findGetParameter from '../../mixins/findGetParameter'
	import VueScrollTo from 'vue-scrollto'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			},
			isCompleted: {
				required: false,
				type: Boolean,
				default: false
			},
			createRoles: {
				required: false,
				type: Array
			} 
		},

		components: {
			Comment,
			NewComment
		},

		mixins: [
			findGetParameter
		],

		computed: {
			...mapGetters({
				comments: 'comments/comments',
				userId: 'logbooks/userId',
				logbookId: 'logbooks/logbookId'
			})
		},

		methods: {
			...mapActions({
				fetch: 'comments/fetch'
			}),

			async init () {
				await this.fetch(this.endpoint)

				let commentId = await this.findGetParameter('comment')

				if (commentId) {
					VueScrollTo.scrollTo(`#comment-${commentId}`, 500)

					window.history.replaceState({}, document.title, `/users/${parseInt(this.userId)}/logbooks/${parseInt(this.logbookId)}`);
				}
			}
		},

		mounted () {
			this.init()
		}
	}
</script>