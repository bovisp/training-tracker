<template>
	<section class="section" style="position: relative;">
		<div class="columns">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Status
				</h2>
			</div>
		</div>

		<div class="columns is-desktop">
			<Status 
				v-for="status in statuses"
				:key="status.period"
				:status="status"
			/>
		</div>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Objectives
				</h2>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<Objectives />
			</div>
		</div>
		
		<template v-if="logbooks.length > 0">
			<div class="columns mt-8">
				<div class="column">
					<h2 class="title is-2 has-text-weight-light">
						Logbooks
					</h2>
				</div>
			</div>

			<div class="columns">
				<div class="column">
					<NewEntryDropdown 
						v-if="!allObjectivesComplete"
					/>

					<Logbooks />
				</div>
			</div>

			<div class="columns mt-8">
				<div class="column">
					<h2 class="title is-2 has-text-weight-light">
						Statement of Competency
					</h2>
				</div>
			</div>

			<comments 
				:endpoint="commentsEndpoint"
				:create-roles="['supervisor', 'head_of_operations']"
				:is-completed="allObjectivesComplete"
			/>
		</template>

		<div 
			style="position: fixed; bottom: 0; left: 0; background: #FFF; display: flex; width: 100%; z-index: 10;"
			class="p-4 has-background-white-ter" 
			v-if="hasRoleOf(['supervisor', 'head_of_operations', 'manager'])"
		>
				<button 
					class="button is-info ml-auto"
					@click="submit"
				>
					<i class="mdi mdi-content-save mr-2"></i>

					{{ trans('app.components.userlessons.save') }}
				</button>
		</div>

		<EntryModal />
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Objectives from './objectives/Objectives'
	import NewEntryDropdown from './logbooks/NewEntryDropdown'
	import Logbooks from './logbooks/Logbooks'
	import EntryModal from './logbooks/EntryModal'
	import Status from './statuses/Status'
	import Comments from '../comments/Comments'

	export default {
		props: {
			userlessonId: {
				type: Number,
				required: true
			}
		},

		components: {
			Objectives,
			NewEntryDropdown,
			Logbooks,
			EntryModal,
			Status,
			Comments
		},

		computed: {
			...mapGetters({
				userlesson: 'userlessons/userlesson',
				logbooks: 'userlessons/logbooks',
				allObjectivesComplete: 'userlessons/allObjectivesComplete',
				statuses: 'userlessons/statuses'
			}),

			commentsEndpoint () {
				return `/users/${this.userlesson.user.id}/userlessons/${this.userlesson.id}/comments`
			}
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetch'
			}),

			submit () {
				console.log('submitting')
			}
		},

		mounted () {
			this.fetch(this.userlessonId)
		}
	}
</script>