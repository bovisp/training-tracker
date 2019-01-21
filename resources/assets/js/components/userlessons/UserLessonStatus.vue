<template>
	<div>
		<h3 class="title is-3 mt-16">
			{{ trans('app.components.userlessons.status') }}
		</h3>

		 <div class="columns is-desktop">
			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp9 }"
			>
				<div class="field">
					<label for="p9" class="label">{{ trans('app.components.userlessons.earlyegthree') }}</label>

					<div class="select is-small" :class="{ 'is-danger': errors.p9 }" >
						<select 
							:value="p9" 
							id="p9" 
							@change="updateStatus({ event: $event, status: 'p9'})"
							:disabled="!hasRoleOf(['supervisor', 'head_of_operations']) || isCompleted"
						>
							<option value=""></option>

							<option 
								v-for="status in filteredStatusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="p9 === status.type"
							></option>
						</select>
					</div>

					<p 
						v-if="errors.p9" 
						v-text="errors.p9[0]"
						class="help is-danger"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp18 }"
			>
				<div class="field">
					<label for="p18" class="label">{{ trans('app.components.userlessons.lateegthree') }}</label>

					<div class="select is-small" :class="{ 'is-danger': errors.p18 }">
						<select 
							:value="p18" 
							id="p18" 
							@change="updateStatus({ event: $event, status: 'p18'})"
							:disabled="!hasRoleOf(['supervisor', 'head_of_operations']) || isCompleted"
						>
							<option value=""></option>

							<option 
								v-for="status in filteredStatusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type === p18"
							></option>
						</select>
					</div>

					<p 
						v-if="errors.p18" 
						v-text="errors.p18[0]"
						class="help is-danger"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp30 }"
			>
				<div class="field">
					<label for="p30" class="label">{{ trans('app.components.userlessons.earlyegfour') }}</label>

					<div class="select is-small" :class="{ 'is-danger': errors.p30 }">
						<select 
							:value="p30" 
							id="p30" 
							@change="updateStatus({ event: $event, status: 'p30'})"
							:disabled="!hasRoleOf(['supervisor', 'head_of_operations']) || isCompleted"
						>
							<option value=""></option>

							<option 
								v-for="status in filteredStatusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type === p30"
							></option>
						</select>
					</div>

					<p 
						v-if="errors.p30" 
						v-text="errors.p30[0]"
						class="help is-danger"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp42 }"
			>
				<div class="field">
					<label for="p42" class="label">{{ trans('app.components.userlessons.lateegfour') }}</label>

					<div class="select is-small" :class="{ 'is-danger': errors.p42 }">
						<select 
							:value="p42" 
							id="p42" 
							@change="updateStatus({ event: $event, status: 'p42'})"
							:disabled="!hasRoleOf(['supervisor', 'head_of_operations']) || isCompleted"
						>
							<option value=""></option>

							<option 
								v-for="status in filteredStatusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type === p42"
							></option>
						</select>
					</div>

					<p 
						v-if="errors.p42" 
						v-text="errors.p42[0]"
						class="help is-danger"
					></p>
				</div>
			</div>
		</div> 
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'

	export default {
		data () {
			return {
				statusTypes: [
					{ type: 'c', name: this.trans('app.components.userlessons.cstatus') },
					{ type: 'd', name: this.trans('app.components.userlessons.dstatus') },
					{ type: 'e', name: this.trans('app.components.userlessons.estatus') }
				],
				statusPeriods: [ 'p9', 'p18', 'p30', 'p42' ],
				allObjectivesCompleted: false
			}
		},

		computed: {
			...mapGetters({
				p9: 'userlessons/p9',
				p18: 'userlessons/p18',
				p30: 'userlessons/p30',
				p42: 'userlessons/p42',

				lessonPeriodp9: 'userlessons/lessonPeriodp9',
				lessonPeriodp18: 'userlessons/lessonPeriodp18',
				lessonPeriodp30: 'userlessons/lessonPeriodp30',
				lessonPeriodp42: 'userlessons/lessonPeriodp42',

				errors: 'errors',

				isCompleted: 'userlessons/isCompleted',
				objectives: 'userlessons/objectives',
			}),

			completed: {
				get () {
					return this.$store.state.userlessons.userlesson.completedObjectives
				},
				set (value) {
					this.$store.commit('userlessons/updateCompletedObjectives', value)
				}
			},

			filteredStatusTypes () {
				if (this.allObjectivesCompleted) {
					return this.statusTypes
				}
				
				return filter(this.statusTypes, status => status.type !== 'c')
			}
		},

		methods: {
			...mapActions({
				updateStatus: 'userlessons/updateStatus'
			})
		},

		mounted () {
			window.events.$on('status-errors', (errors) => {
				this.errors.record(errors)
			})

			window.events.$on('allObjectivesCompleted', completedObjectives => {
				this.allObjectivesCompleted = completedObjectives.length === this.objectives.length
			})
		}
	}
</script>