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

		<article class="message is-info" v-if="comments.length === 0 && newActive === false">
			<div class="message-body">
				{{ trans('app.components.comments.nocomments') }}
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
			createRoles: {
				required: false,
				type: Array
			} 
		},

		components: {
			Comment,
			NewComment
		},

		data () {
			return {
				newActive: false,
				isCompleted: false
			}
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
			setTimeout(() => {
				this.init()
			}, 200)

			window.events.$on('comment:new-active', () => this.newActive = true)

			window.events.$on('comment:new-inactive', () => this.newActive = false)

			window.events.$on('disable', disabled => {
				if (disabled === 0 || disabled === '0') {
					this.isCompleted = false
				} else if (disabled === 1 || disabled === '1') {
					this.isCompleted = true
				}
			})
		}
	}
</script>