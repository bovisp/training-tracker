<template>
	<div>
		<h3 class="title is-3 mt-6">
			Status
		</h3>

		 <div class="columns is-desktop">
			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp9 }"
			>
				<div class="field">
					<label for="p9" class="label">Early EG-03</label>

					<div class="select is-small" :class="{ 'is-danger': errors.has('p9') }" >
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
						v-if="errors.has('p9')" 
						v-text="errors.get('p9')"
						class="help is-danger"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp18 }"
			>
				<div class="field">
					<label for="p18" class="label">Late EG-03</label>

					<div class="select is-small" :class="{ 'is-danger': errors.has('p18') }">
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

					<p 
						v-if="errors.has('p18')" 
						v-text="errors.get('p18')"
						class="help is-danger"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp30 }"
			>
				<div class="field">
					<label for="p30" class="label">Early EG-04</label>

					<div class="select is-small" :class="{ 'is-danger': errors.has('p30') }">
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

					<p 
						v-if="errors.has('p30')" 
						v-text="errors.get('p30')"
						class="help is-danger"
					></p>
				</div>
			</div>

			<div 
				class="column"
				:class="{ 'has-background-grey-lighter': lessonPeriodp42 }"
			>
				<div class="field">
					<label for="p42" class="label">late EG-04</label>

					<div class="select is-small" :class="{ 'is-danger': errors.has('p42') }">
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

					<p 
						v-if="errors.has('p42')" 
						v-text="errors.get('p42')"
						class="help is-danger"
					></p>
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
				errors: new Error
			}
		},

		computed: {
			p9: {
				get () {
					return this.$store.state.userlessons.userlesson.status.p9
				},
				set (value) {
					this.$store.commit('userlessons/updateP9', value)
				}
			},
			p18: {
				get () {
					return this.$store.state.userlessons.userlesson.status.p18
				},
				set (value) {
					this.$store.commit('userlessons/updateP18', value)
				}
			},
			p30: {
				get () {
					return this.$store.state.userlessons.userlesson.status.p30
				},
				set (value) {
					this.$store.commit('userlessons/updateP30', value)
				}
			},
			p42: {
				get () {
					return this.$store.state.userlessons.userlesson.status.p42
				},
				set (value) {
					this.$store.commit('userlessons/updateP42', value)
				}
			},
			lessonPeriodp9: {
				get () {
					return this.$store.state.userlessons.userlesson.lesson.p9
				}
			},
			lessonPeriodp18: {
				get () {
					return this.$store.state.userlessons.userlesson.lesson.p18
				}
			},
			lessonPeriodp30: {
				get () {
					return this.$store.state.userlessons.userlesson.lesson.p30
				}
			},
			lessonPeriodp42: {
				get () {
					return this.$store.state.userlessons.userlesson.lesson.p42
				}
			}
			// ...mapState({
			// 	lessonPeriods: state => {
			// 		console.log(this.$store.state.userlessons.userlesson)
			// 		return {
			// 			p9: state.userlessons.userlesson.lesson.p9,
			// 			p18: state.userlessons.userlesson.lesson.p18,
			// 			p30: state.userlessons.userlesson.lesson.p30,
			// 			p42: state.userlessons.userlesson.lesson.p42
			// 		}
			// 	}
			// })
		},

		mounted () {
			window.events.$on('status-errors', (errors) => {
				this.errors.record(errors)
			})
		}
	}
</script>