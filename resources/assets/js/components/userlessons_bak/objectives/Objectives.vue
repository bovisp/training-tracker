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

		<article class="message is-danger mt-4" v-if="filteredKeys(errors, /objectives/).length">
			<div class="message-body">
				<div class="content">
					<ul class="mt-0">
						<li v-for="error in filteredKeys(errors, /objectives/)">
							{{ errors[error][0] }}
						</li>
					</ul>
				</div>
			</div>
		</article>
	</div>
</template>

<script>
	export default {
		data() {
            return {
                completedObjectives: [],
                objectives: [],
                disable: false
            }
        },

        computed: {
        	hasLogbooksNotRequired () {
        		return _.find(this.objectives, objective => objective.notebook_required === 0)
        	},

        	isDisabled () {
        		if (this.disable) {
        			return true
        		}

        		if (!this.hasRoleOf(['supervisor', 'head_of_operations'])) {
        			return true
        		}

        		return false
        	}
        },

		watch: {
			completedObjectives () {
				this.$emit('updateobjectives', this.completedObjectives)
			}
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
		},

		mounted () {
			window.events.$on('objectives', ({ objectives, completed }) => {
				this.completedObjectives = _.map(completed, objective => objective.id)
				this.objectives = objectives
			})

			window.events.$on('objectives:reset', objectives => {
				this.completedObjectives = objectives
			})

			window.events.$on('disable-objectives', () => {
				this.disable = true
			})

			window.events.$on('enable-objectives', () => {
				this.disable = false
			})
		}
	}
</script>