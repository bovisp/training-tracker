<template>
	<div>
		<EntrySettings 
			@entryedit="editing = true"
		/>

		<article 
			class="content" 
			v-if="!editing"
			v-html="entry.body"
		></article>

		<EditEntry 
			@entrycancel="editing = false"
			@entryupdate="update"
			:data="entry.body"
			v-else
		/>

		<h3 class="is-3 has-text-weight-light title">
			Files
		</h3>

		<EntryFiles 
			:entry="entry"
		/>

		<h3 class="title is-3 has-text-weight-light mt-8">
			{{ trans('app.components.logbooks.comments') }}
		</h3>

		<template v-if="typeof this.entry.id !== 'undefined'">
			<Comments 
				:endpoint="commentsEndpoint"
				:create-roles="['supervisor', 'head_of_operations', 'apprentice']"
				:is-completed="false"
			/>
		</template>
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import EntrySettings from './EntrySettings'
	import EditEntry from './EditEntry'
	import EntryFiles from './EntryFiles'
	import Comments from '../../comments/Comments'

	export default {
		props: {
			entryId: {
				type: Number,
				required: true
			}
		},

		components: {
			EntrySettings,
			EditEntry,
			EntryFiles,
			Comments
		},

		data () {
			return {
				editing: false
			}
		},

		computed: {
			...mapGetters({
				entry: 'userlessons/entry',
				userlesson: 'userlessons/userlesson'
			}),

			commentsEndpoint () {
				return `/users/${this.userlesson.user.id}/entries/${this.entry.id}/comments`
			}
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetchEntry',
				updateEntry: 'userlessons/updateEntry',
				fetchLogbooks: 'userlessons/fetchLogbooks'
			}),

			async update (data) {
				let response = await this.updateEntry({ data, entryId: this.entryId })

				if (response.status === 200) {
					console.log(response)
					await this.fetchLogbooks(this.userlesson.id)

					await this.fetch(this.entryId)

            		this.editing = false

            		this.$toast.open({
		                message: response.data.flash,
		                position: 'is-top-right',
		                type: 'is-success'
            		})
				}

				if (response.status === 422) {
					this.$toast.open({
		                message: response.data.message,
		                position: 'is-top-right',
		                type: 'is-danger'
	        		})
				}
			}
		},

		mounted () {
			this.fetch(this.entryId)
		}
	}
</script>