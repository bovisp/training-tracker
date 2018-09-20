<template>
	<div>
		<new-comment 
			:endpoint="endpoint" 
			v-if="this.hasRoleOf('head_of_operations')"
		/>
	
		<template v-if="comments.length">
			<ul>
				<comment 
					v-for="comment in comments" 
					:key="comment.id"
					:comment="comment" 
				/>
			</ul>
		</template>

		<article class="message is-info" v-else>
			<div class="message-body">
				No comments to display.
			</div>
		</article>

		<button 
			class="button mt-6"
			@click.prevent="more"
			v-if="meta.current_page < meta.last_page"
		>
			Show more comments
		</button>
	</div>
</template>

<script>
	import NewComment from './NewComment'
	import Comment from './Comment'

	export default {
		props: ['endpoint'],

		components: {
			NewComment,
			Comment
		},

		data () {
			return {
				comments: [],
				meta: {}
			}
		},

		methods: {
			async prependComment (comment) {
				await this.fetchMeta()

				if (this.meta.current_page === this.meta.last_page) {
					this.comments.push(comment)
				}
			},

			fetchMeta () {
				axios.get(`${this.endpoint}?page=${this.meta.current_page}`)
					.then(({data}) => {
						this.meta = data.meta
					})
			},

			fetch (page = 1) {
				axios.get(`${this.endpoint}?page=${page}`)
					.then(({data}) => {
						this.comments = data.data
						this.meta = data.meta
					})
			},

			more () {
				axios.get(`${this.endpoint}?page=${this.meta.current_page + 1}`)
					.then(({data}) => {
						this.comments.push(...data.data)
						this.meta = data.meta
					})
			}
		},

		mounted () {
			this.fetch(1)

			window.events.$on('comment:stored', this.prependComment)
		}
	}
</script>