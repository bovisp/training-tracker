<template>
	<div>
		<ul>
			<li
				v-for="objective in objectives"
				:key="objective.id"
				class="mt-1"
			>
				<b-checkbox v-model="completedObjectives"
	                :native-value="objective.id"
	                type="is-success"
	                :disabled="isDisabled"
	            >
	            	<i class="mdi mdi-information-variant mr-1" v-if="!objective.notebook_required"></i>
	        		{{ objective.name }}
	        	</b-checkbox>
			</li>
		</ul>

		<div class="has-text-grey-light mt-4" v-if="hasLogbooksNotRequired">
			<i class="mdi mdi-information-variant mr-1"></i>
			= Logbook not required for this objective
		</div>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'

	export default {
		computed: {
			...mapGetters({
				objectives: 'userlessons/objectives'
			}),

			completedObjectives: {
				get () {
					return this.$store.state.userlessons.form.completedObjectives
				},

				set (value) {
					this.$store.commit('userlessons/UPDATE_COMPLETED_OBJECTIVES', value)
				}
			},

			isDisabled () {
				return false
			},

			hasLogbooksNotRequired () {
        		return _.find(this.objectives, objective => objective.notebook_required === 0)
        	},
		}
	}
</script>