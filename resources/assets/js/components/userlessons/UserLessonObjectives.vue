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
					<input 
						type="checkbox" 
						v-model="completed" 
						:value="objective.id"
					>
				
					<strong>{{ objective.number }} - </strong>{{ objective.name }}
				</label>
			</li>
		</ul>

		<article v-if="errors.objectives[0]" class="message is-danger mt-4">
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
				errors: 'userlessons/errors'
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