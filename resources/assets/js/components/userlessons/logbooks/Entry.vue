<template>
	<section>
		<NewEntry v-if="logbookId"/>

		<template v-else>
			{{ objectiveCompleted }}

			<EntrySettings 
				@entryedit="editing = true"
				@entrydelete="destroy"
				v-if="!objectiveCompleted"
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
				:is-completed="objectiveCompleted"
			/>

			<h3 class="title is-3 has-text-weight-light mt-8">
				{{ trans('app.components.logbooks.comments') }}
			</h3>

			<Comments 
				:endpoint="commentsEndpoint"
				:create-roles="['supervisor', 'head_of_operations', 'apprentice']"
				:is-completed="objectiveCompleted"
			/>
		</template>
	</section>
</template>

<script>
	import { mapGetters } from 'vuex'
	import NewEntry from './NewEntry'
	import EntrySettings from './EntrySettings'
	import EditEntry from './EditEntry'
	import EntryFiles from './EntryFiles'
	import Comments from '../../comments/Comments'

	export default {
		data () {
			return {
				editing: false
			}
		},

		components: {
			NewEntry,
			EntrySettings,
			EditEntry,
			EntryFiles,
			Comments
		},

		computed: {
			...mapGetters({
				entry: 'userlessons/entry',
				logbookId: 'userlessons/logbookId',
				logbooks: 'userlessons/logbooks',
				userlesson: 'userlessons/userlesson',
				form: 'userlessons/form'
			}),

			commentsEndpoint () {
				return `/users/${this.userlesson.user.id}/entries/${this.entry.id}/comments`
			},

			objectiveCompleted () {
				console.log(this.form.completedObjectives, this.entry.objective_id)
				if (_.indexOf(this.form.completedObjectives, this.entry.objective_id) >= 0) {
					return true
				}

				return false
			}
		},

		methods: {
			destroy () {
				console.log("destroyed")
			},

			update () {
				console.log("updating")
			}
		}
	}
</script>