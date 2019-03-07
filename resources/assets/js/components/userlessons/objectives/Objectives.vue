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
	                :disabled="statusComplete || !hasRoleOf(['supervisor', 'head_of_operations'])"
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

		<article class="message is-danger mt-4" v-if="filteredKeys(errors, /completedObjectives/).length">
			<div class="message-body">
				<div class="content">
					<ul class="mt-0">
						<li v-for="error in filteredKeys(errors, /completedObjectives/)">
							{{ errors[error][0] }}
						</li>
					</ul>
				</div>
			</div>
		</article>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'

	export default {
		computed: {
			...mapGetters({
				objectives: 'userlessons/objectives',
				statusComplete: 'userlessons/statusComplete'
			}),

			completedObjectives: {
				get () {
					return this.$store.state.userlessons.form.completedObjectives
				},

				set (value) {
					this.$store.commit('userlessons/UPDATE_COMPLETED_OBJECTIVES', value)
				}
			},

			hasLogbooksNotRequired () {
        		return _.find(this.objectives, objective => objective.notebook_required === 0)
        	},
		},

		methods: {
			filteredKeys (obj, filter) {
				let key, keys = []

				for (key in obj) {
					if (obj.hasOwnProperty(key) && filter.test(key)) {
						keys.push(key)
					}
				}

	  			return keys
			}
		}
	}
</script>