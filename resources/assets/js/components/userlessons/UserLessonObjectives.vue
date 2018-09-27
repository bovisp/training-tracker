<template>
	<div>
		<h3 class="title is-3 mt-16">
			Objectives
		</h3>

		<ul>
			<li 
				v-for="objective in objectives" 
				:key="objective.id"
				class="mb-4"
			>
				<label 
					class="checkbox" 
				>
					<template v-if="hasRoleOf('administrator', 'supervisor', 'head_of_operations') && !isCompleted">
						<input 
							type="checkbox" 
							v-model="completed" 
							:value="objective.id"
						>
					</template>

					<template v-else>
						<span
							v-if="completed.indexOf(objective.id) > -1"
							v-html="`&check;`"
							style="color: green;"
							class="mr-4"
						></span>

						<span
							v-else
							v-html="`&ndash;`"
							class="has-text-grey has-text-weight-bold mr-4"
						></span>
					</template>
				
					<strong>{{ objective.number }} - </strong>{{ objective.name }}
				</label>
			</li>
		</ul>

		<article v-if="errors.objectives" class="message is-danger mt-4">
			<div class="message-body content">
				<ul class="mt-0">
					<li v-text="errors.objectives[0]"></li>
				</ul>
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
				errors: 'errors',
				isCompleted: 'userlessons/isCompleted'
			}),

			completed: {
				get () {
					return this.$store.state.userlessons.userlesson.completedObjectives
				},
				set (value) {
					this.$store.commit('userlessons/updateCompletedObjectives', value)
				}
			}
		},

		mounted () {
			window.events.$on('objective-errors', (errors) => {
				this.errors.record(errors)
			})
		}
	}
</script>