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
		</template>

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
			Status
		},

		computed: {
			...mapGetters({
				userlesson: 'userlessons/userlesson',
				logbooks: 'userlessons/logbooks',
				allObjectivesComplete: 'userlessons/allObjectivesComplete',
				statuses: 'userlessons/statuses'
			})
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetch'
			})
		},

		mounted () {
			this.fetch(this.userlessonId)
		}
	}
</script>