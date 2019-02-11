<template>
	<section class="section">
		<div class="columns is-desktop">
			<Status 
				v-for="status in statusPeriods"
				:status="status"
				:key="status"
				@statuschanged="statusChanged"
			/>
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
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Status from './statuses/Status'

	export default {
		props: {
			initialUserlesson: {
				type: Object,
				required: true
			}
		},

		components: {
			Status
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
					}
				}
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

			async submit () {
				let response = await this.update()

				if (response.status === 200) {
					this.$toast.open({
		                message: response.data.flash,
		                position: 'is-top-right',
		                type: 'is-success'
            		})
				}

				if (response.status === 422) {
					this.$toast.open({
		                message: response.data.message,
		                position: 'is-top-right',
		                type: 'is-danger'
	        		})
				}
			},

			setStatuses () {
				setTimeout(() => {
					forEach(this.statusPeriods, period => {
						this.form.statuses[period] = this.userlesson[period]
						window.events.$emit(`status-${period}`, {
							period: this.userlesson[period],
							isCovered: this.userlesson.lesson[period],
							statusLabel: this.statusLabels[period]
						})
					})
				}, 200)
			}
		},

		mounted () {
			this.initialize(this.initialUserlesson)

			this.setStatuses()
		}
	}
</script>