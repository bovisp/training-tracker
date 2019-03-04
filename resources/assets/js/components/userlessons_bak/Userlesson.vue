<template>
	<section class="section" style="position: relative;">
		<div class="columns">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Status
				</h2>
			</div>
		</div>

		<div class="columns is-desktop">
			<Status 
				v-for="status in statusPeriods"
				:status="status"
				:key="status"
				@statuschanged="statusChanged"
			/>
		</div>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Objectives
				</h2>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<Objectives	
					@updateobjectives="objectivesChanged"
				/>
			</div>
		</div>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Logbooks
				</h2>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<NewEntryDropdown 
					v-if="!hideDropdown"
				/>

				<Logbooks 
					:userlesson="initialUserlesson"
				/>
			</div>
		</div>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Statement of Competency
				</h2>
			</div>
		</div>

		<comments 
			:endpoint="commentsEndpoint"
			:create-roles="['supervisor', 'head_of_operations']"
			:is-completed="hideDropdown"
		/>

		<div 
			style="position: fixed; bottom: 0; left: 0; background: #FFF; display: flex; width: 100%; z-index: 10;"
			class="p-4 has-background-white-ter" 
			v-if="hasRoleOf(['supervisor', 'head_of_operations', 'manager'])"
		>
				<button 
					class="button is-info ml-auto"
					@click="submit"
				>
					<i class="mdi mdi-content-save mr-2"></i>

					{{ trans('app.components.userlessons.save') }}
				</button>
		</div>

		<b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Status from './statuses/Status'
	import Objectives from './objectives/Objectives'
	import Comments from '../comments/Comments'
	import Logbooks from './logbooks/Logbooks'
	import NewEntryDropdown from './logbooks/NewEntryDropdown'

	export default {
		props: {
			initialUserlesson: {
				type: Object,
				required: true
			}
		},

		components: {
			Status,
			Objectives,
			Comments,
			Logbooks,
			NewEntryDropdown
		},

		data () {
			return {
				statusPeriods: [ 'p9', 'p18', 'p30', 'p42' ],
				statuses: [ 
					{ name: 'Early EG-03', period: 'p9' },
					{ name: 'Late EG-03', period: 'p18' },
					{ name: 'Early EG-04', period: 'p30' },
					{ name: 'Late EG-04', period: 'p42' }
				],
				form: {
					statuses: {
						p9: '',
						p18: '',
						p30: '',
						p42: ''
					},
					objectives: []
				},
				isLoading: false,
				commentsEndpoint: '',
				hideDropdown: false
			}
		},

		computed: {
			...mapGetters({
				userlesson: 'userlessons/userlesson',
				logbooks: 'userlessons/logbooks'
			})
		},

		watch: {
			form: {
				handler (data) {
					this.updateForm(data)

					window.events.$emit('objectivescompleted', this.userlesson.lesson.objectives.length === this.form.objectives.length)
				},
				deep: true
			}
		},

		methods: {
			...mapActions({
				initialize: 'userlessons/initialize',
				updateForm: 'userlessons/updateForm',
				update: 'userlessons/update'
			}),

			statusChanged (data) {
				this.form.statuses[data.status] = data.value

				if (data.value === 'c') {
					window.events.$emit('disable-objectives')

					this.hideDropdown = true
				} else {
					window.events.$emit('enable-objectives')

					this.hideDropdown = false
				}
			},

			objectivesChanged (data) {
				this.form.objectives = data

				let objectivesCompleted = this.userlesson.lesson.objectives.length === this.form.objectives.length

				let cIndex = _.findKey(this.form.statuses, status => status === 'c')

				console.log(!objectivesCompleted && cIndex !== 'undefined')

				if (!objectivesCompleted && cIndex !== 'undefined') {
					this.form.statuses[cIndex] = null
				}
			},

			async submit () {
				this.isLoading = true

				let response = await this.update()

				if (response.status === 200) {
					await this.initialize(response.data.userlesson)

            		await this.setData()

            		this.isLoading = false

            		this.$toast.open({
		                message: response.data.flash,
		                position: 'is-top-right',
		                type: 'is-success'
            		})
				}

				if (response.status === 422) {
					this.isLoading = false

					window.events.$emit('objectives:reset', _.map(this.userlesson.user.objectives, objective => objective.id))

					this.$toast.open({
		                message: response.data.message,
		                position: 'is-top-right',
		                type: 'is-danger'
	        		})
				}
			},

			setData () {
				setTimeout(() => {
					forEach(this.statusPeriods, period => {
						this.form.statuses[period] = this.userlesson[period]

						if (this.userlesson[period] === 'c') {
							this.hideDropdown = true

							window.events.$emit('disable-objectives')
						}

						window.events.$emit(`status-${period}`, {
							period: this.userlesson[period],
							isCovered: this.userlesson.lesson[period],
							statusLabel: this.statusLabels[period]
						})
					})

					window.events.$emit('objectives', {
						objectives: this.userlesson.lesson.objectives,
						completed: this.userlesson.user.objectives
					})
				}, 100)

				this.commentsEndpoint = `/users/${this.userlesson.user.id}/userlessons/${this.userlesson.id}/comments`
			}
		},

		mounted () {
			this.initialize(this.initialUserlesson)

			this.setData()
		}
	}
</script>