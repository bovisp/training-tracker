<template>
	<div>
		<template v-if="!logbook">
			<EntrySettings 
				@entryedit="editing = true"
				@entrydelete="destroy"
				v-if="!objectiveCompleted()"
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
				:is-completed="objectiveCompleted() === true"
			/>

			<h3 class="title is-3 has-text-weight-light mt-8">
				{{ trans('app.components.logbooks.comments') }}
			</h3>

			<template v-if="typeof this.entry.id !== 'undefined'">
				<Comments 
					:endpoint="commentsEndpoint"
					:create-roles="['supervisor', 'head_of_operations', 'apprentice']"
					:is-completed="objectiveCompleted === true"
				/>
			</template>
		</template>

		<template v-else>
			<NewEntry 
				:logbook="logbook"
			/>
		</template>
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import EntrySettings from './EntrySettings'
	import EditEntry from './EditEntry'
	import EntryFiles from './EntryFiles'
	import NewEntry from './NewEntry'
	import Comments from '../../comments/Comments'

	export default {
		props: {
			entryId: {
				type: Number,
				required: false
			},
			logbookId: {
				type: Number,
				required: false,
				default: null
			}
		},

		components: {
			EntrySettings,
			EditEntry,
			EntryFiles,
			NewEntry,
			Comments
		},

		data () {
			return {
				editing: false,
				logbook: this.logbookId
			}
		},

		computed: {
			...mapGetters({
				entry: 'userlessons/entry',
				userlesson: 'userlessons/userlesson',
				form: 'userlessons/form'
			}),

			commentsEndpoint () {
				return `/users/${this.userlesson.user.id}/entries/${this.entry.id}/comments`
			}
		},

		methods: {
			...mapActions({
				fetchEntry: 'userlessons/fetchEntry',
				updateEntry: 'userlessons/updateEntry',
				destroyEntry: 'userlessons/destroyEntry',
				fetchLogbooks: 'userlessons/fetchLogbooks'
			}),

			async destroy () {
				let response = await this.destroyEntry(this.entryId)

				await this.fetchLogbooks(this.userlesson.id)

				this.$emit('closemodal')

				this.$toast.open({
	                message: response.data.flash,
	                position: 'is-top-right',
	                type: 'is-success'
        		})
			},

			async update (data) {
				let response = await this.updateEntry({ data, entryId: this.entryId })

				if (response.status === 200) {
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
			},

			objectiveCompleted () {
				let entryObjective = _.find(this.userlesson.logbooks, ['id', this.entry.logbook])

				if (typeof entryObjective !== 'undefined') {
					if (_.indexOf(this.form.objectives, entryObjective.objective_id) >= 0) {
						return true
					}
				}

				return false
			},

			async fetch (entry = null) {
				let response = await this.fetchEntry(this.entryId)

				await this.objectiveCompleted()
			}
		},

		mounted () {
			if (!this.logbook) {
				this.fetch()
			}

			window.events.$on('entrycreated', () => {
				this.logbook = null

				setTimeout(() => {
					this.objectiveCompleted()
				}, 1000)
			})
		}
	}
</script>