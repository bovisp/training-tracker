<template>
	<section>
		<NewEntry v-if="logbookId"/>

		<template v-else>
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
				v-if="Object.keys(entry).length > 0"
				:endpoint="commentsEndpoint"
				:create-roles="['supervisor', 'apprentice']"
				:is-completed="objectiveCompleted"
			/>
		</template>

		<b-loading :active.sync="isLoading"></b-loading>
	</section>
</template>

<script>
	import { mapGetters, mapActions, mapMutations } from 'vuex'
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
				form: 'userlessons/form',
				isLoading: 'userlessons/isLoading'
			}),

			commentsEndpoint () {
				return `/users/${this.userlesson.user.id}/entries/${this.entry.id}/comments`
			},

			objectiveCompleted () {
				if (_.indexOf(this.form.completedObjectives, this.entry.objective_id) >= 0) {
					return true
				}

				return false
			}
		},

		methods: {
			...mapActions({
				updateEntry: 'userlessons/updateEntry',
				destroyEntry: 'userlessons/destroyEntry'
			}),

			...mapMutations({
				updateLoading: 'userlessons/UPDATE_LOADING'
			}),

			async destroy () {
				this.updateLoading()

				let response = await this.destroyEntry(this.entry.id)

				this.updateLoading()

				this.$toast.open({
					message: response.data.flash,
					position: 'is-top-right',
					type: 'is-success'
				})
			},

			async update (data) {
				let response = await this.updateEntry(data)

				if (response.status === 200) {
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
		}
	}
</script>