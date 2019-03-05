<template>
	<div>
		<div class="flex items-end mb-4">
			<div class="field mb-0">
				<label for="new_entry" class="label">Add new entry</label>

				<div class="select">
					<select id="new_entry" v-model="logbookId">
						<template v-if="typeof userlesson.logbooks !== 'undefined' && Object.keys(userlesson.logbooks).length > 0">
							<option 
								:value="logbook.id"
								v-for="logbook in filteredLogbooks"
								v-if="logbook.objective.notebook_required"
							>{{ logbook.objective.name }}</option>
						</template>
					</select>
				</div>
			</div>

			<button 
				class="button is-link ml-4"
				@click.prevent="createEntry"
			>Create</button>
		</div>

		<b-modal 
			:active.sync="isActive" 
			:width="960" 
			scroll="keep" 
			:can-cancel="['escape', 'x']"
		>
			<div class="card">
				<div class="card-content">
					<EntryModal 
						:logbookId="logbookId"
					/>
				</div>
			</div>
		</b-modal>
	</div>
</template>

<script>
	import EntryModal from './EntryModal'
	import { mapActions, mapGetters } from 'vuex'

	export default {
		data () {
			return { 
				logbookId: null,
				isActive: false,
				userlesson: {
					logbooks: {}
				}
			}
		},

		components: {
			EntryModal
		},

		computed: {
			...mapGetters({
				form: 'userlessons/form'
			}),

			filteredLogbooks () {
				return _.filter(
					this.userlesson.logbooks, 
					logbook => _.indexOf(
						this.form.objectives, 
						logbook.objective_id
					) === -1
				)
			}
		},

		methods: {
			createEntry () {
				if (!this.logbookId) {
					return
				}

				this.isActive = true
			}
		},

		mounted () {
			window.events.$on('entrycreated', () => this.logbookId = null)

			setTimeout(() => {
				this.userlesson.logbooks = this.$store.state.userlessons.userlesson.logbooks
			}, 500)
		}
	}
</script>