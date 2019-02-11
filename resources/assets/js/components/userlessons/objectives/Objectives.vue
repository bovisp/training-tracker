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
	                :disabled="!hasRoleOf(['supervisor', 'head_of_operations'])"
	            >
	            	<i class="mdi mdi-information-variant mr-1" v-if="!objective.notebook_required"></i>
	        		{{ objective.name }}
	        	</b-checkbox>
			</li>
		</ul>

		<div class="has-text-grey-light mt-4">
			<i class="mdi mdi-information-variant mr-1"></i>
			= Logbook not required for this objective
		</div>

		<article class="message is-danger mt-4" v-if="errors.objectives">
			<div class="message-body">
				{{ errors.objectives[0] }}
			</div>
		</article>
	</div>
</template>

<script>
	export default {
		data() {
            return {
                completedObjectives: [],
                objectives: []
            }
        },

		watch: {
			completedObjectives () {
				this.$emit('updateobjectives',this.completedObjectives)
			}
		},

		mounted () {
			window.events.$on('objectives', ({ objectives, completed }) => {
				this.completedObjectives = _.map(completed, objective => objective.id)
				this.objectives = objectives
			})
		}
	}
</script>