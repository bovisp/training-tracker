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

		<article v-if="errors.has('objectives')" class="message is-danger mt-4">
			<div class="message-body content">
				<ul class="mt-0">
					<li v-text="errors.get('objectives')"></li>
				</ul>
			</div>
		</article>
	</div>
</template>

<script>
	import Error from '../../classes/Error'

	export default {
		data () {
			return {
				errors: new Error
			}
		},

		computed: {
			objectives: {
				get () {
					return this.$store.state.userlessons.userlesson.objectives
				}
			},
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