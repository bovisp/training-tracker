<template>
	<section class="section">
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
					Statement of Competency
				</h2>
			</div>
		</div>

		<comments 
			:endpoint="commentsEndpoint"
			:create-roles="['supervisor', 'head_of_operations']"
		/>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Sign off by Manager or Head of Operations
				</h2>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<Completed 
					@updatecompleted="completedChanged"
				/>
			</div>
		</div>

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
	import Completed from './completed/Completed'
	import Comments from '../comments/Comments'

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
			Completed,
			Comments
		},

		data () {
			return {
				statusPeriods: [ 'p9', 'p18', 'p30', 'p42' ],
				statusLabels: { 
					p9: 'Early EG-03', 
					p18: 'Late EG-03', 
					p30: 'Early EG-04',
					p42: 'Late EG-04'
				},
				form: {
					statuses: {
						p9: '',
						p18: '',
						p30: '',
						p42: ''
					},
					objectives: [],
					completed: 0
				},
				isLoading: false,
				commentsEndpoint: ''
			}
		},

		computed: {
			...mapGetters({
				userlesson: 'userlessons/userlesson'
			})
		},

		watch: {
			form: {
				handler (data) {
					this.updateForm(data)

					window.events.$emit('disable', data.completed)

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
			},

			objectivesChanged (data) {
				this.form.objectives = data
			},

			completedChanged (data) {
				this.form.completed = data
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

				if (response.status === 422 && this.errors.completed) {
					this.form.completed = 0

	                window.events.$emit('removecompletion')

	                this.isLoading = false

					this.$dialog.alert({
	                    title: this.trans('app.components.userlessons.incomplete'),
	                    message: this.errors.completed[0],
	                    type: 'is-danger'
	                })

	                return
				}

				if (response.status === 422) {
					this.isLoading = false

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

					window.events.$emit('completed', {
						completed: this.userlesson.completed
					})
				}, 100)

				window.events.$emit('disable', this.userlesson.completed)

				this.commentsEndpoint = `/users/${this.userlesson.user.id}/userlessons/${this.userlesson.id}/comments`
			}
		},

		mounted () {
			this.initialize(this.initialUserlesson)

			this.setData()
		}
	}
</script>