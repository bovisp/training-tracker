<template>
	<div>
		<h3 class="title is-3 mt-6">
			Status
		</h3>

		 <div class="columns is-desktop">
			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriods.p9 }"
			>
				<div class="field">
					<label for="p9" class="label">Early EG-03</label>

					<div class="select is-small" :class="{ 'is-danger': errors['p9'] }" >
						<select v-model="p9" id="p9">
							<option value=""></option>

							<option 
								v-for="status in statusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type == p9"
							></option>
						</select>
					</div>

					<p 
						class="help is-danger"
						:class="{ 'is-block': errors['p9'] }" 
			            v-text="errors['p9']" 
			            v-show="errors['p9']"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriods.p18 }"
			>
				<div class="field">
					<label for="p18" class="label">Late EG-03</label>

					<div class="select is-small">
						<select v-model="p18" id="p18">
							<option value=""></option>

							<option 
								v-for="status in statusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type == p18"
							></option>
						</select>
					</div>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriods.p30 }"
			>
				<div class="field">
					<label for="p30" class="label">Early EG-04</label>

					<div class="select is-small">
						<select v-model="p30" id="p30">
							<option value=""></option>

							<option 
								v-for="status in statusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type == p30"
							></option>
						</select>
					</div>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriods.p42 }"
			>
				<div class="field">
					<label for="p42" class="label">late EG-04</label>

					<div class="select is-small">
						<select v-model="p42" id="p42">
							<option value=""></option>

							<option 
								v-for="status in statusTypes" 
								:value="status.type" 
								:key="status.type" 
								v-text="status.name"
								:selected="status.type == p42"
							></option>
						</select>
					</div>
				</div> 
			</div>
		</div> 
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	import Error from '../../classes/Error'

	export default {
		data () {
			return {
				statusTypes: [
					{ type: 'c', name: 'C – Module Complete' },
					{ type: 'd', name: 'D – Deferred to next evaluation period' },
					{ type: 'e', name: 'E – Exempt based on location requirements' }
				],
				errors: []
			}
		},

		computed: {
			p9: {
				get () {
					return this.$store.state.userlesson.status.p9
				},
				set (value) {
					this.$store.commit('updateP9', value)
				}
			},
			p18: {
				get () {
					return this.$store.state.userlesson.status.p18
				},
				set (value) {
					this.$store.commit('updateP18', value)
				}
			},
			p30: {
				get () {
					return this.$store.state.userlesson.status.p30
				},
				set (value) {
					this.$store.commit('updateP30', value)
				}
			},
			p42: {
				get () {
					return this.$store.state.userlesson.status.p42
				},
				set (value) {
					this.$store.commit('updateP42', value)
				}
			},
			...mapState({
				lessonPeriods: state => {
					return {
						p9: state.userlesson.lesson.p9,
						p18: state.userlesson.lesson.p18,
						p30: state.userlesson.lesson.p30,
						p42: state.userlesson.lesson.p42
					}
				}
			})
		},

		mounted () {
			window.events.$on('status-errors', (errors) => {
				this.errors = errors
			})
		}
	}
</script>