<template>
	<div>
		<div class="flex items-end mb-4">
			<div class="field mb-0">
				<label for="new_entry" class="label">Add new entry</label>

				<div class="select">
					<select id="new_entry" v-model="logbookId">
						<template v-if="logbooks.length">
							<option 
								:value="logbook.id"
								v-for="logbook in filteredLogbooks"
								:key="logbook.id"
							>{{ textTruncate(logbook.objective.name, 50) }}</option>
						</template>
					</select>
				</div>
			</div>

			<button 
				class="button is-link ml-4"
				@click.prevent="open({entryId: null, logbookId}); logbookId = '';"
			>Create</button>
		</div>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex' 

	export default {
		data () {
			return {
				logbookId: ''
			}
		},

		computed: {
			...mapGetters({
				logbooks: 'userlessons/logbooks',
				form: 'userlessons/form'
			}),

			filteredLogbooks () {
				return _.filter(
					this.logbooks, 
					logbook => _.indexOf(
						this.form.completedObjectives, 
						logbook.objective_id
					) === -1
				)
			}
		},

		methods: {
			...mapActions({
				open: 'userlessons/open'
			})
		}
	}
</script>