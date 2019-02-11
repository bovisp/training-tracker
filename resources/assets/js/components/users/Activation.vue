<template>
	<dd class="is-flex items-center">
		{{ userActiveStatus }}

		<div v-if="hasRoleOf(['supervisor', 'head_of_operations', 'manager']) && authUser !== user.id">
			<button 
				class="button is-text is-small"
				@click.prevent="isActive = !isActive"
			>
				{{ activationAction }}
			</button>

			<b-modal :active.sync="isActive" has-modal-card>
				<div class="modal-card">
					<header class="modal-card-head">
                        <p class="modal-card-title">
                        	Deactivate {{ user.firstname }} {{ user.lastname }}
                        </p>
                    </header>

					<section class="modal-card-body">
						<template v-if="user.active">
							<b-field label="Deactivation date">
						        <b-datepicker
						            placeholder="Select a deactivation date..."
						            icon="calendar-today"
						            v-model="deactivatedDate">
						        </b-datepicker>
						    </b-field>

						    <p 
								class="help is-danger"
								:class="{ 'is-block': errors.has('deactivated_at') }" 
					            v-text="errors.get('deactivated_at')" 
					            v-show="errors.has('deactivated_at')"
							></p>

						    <b-field>
						        <b-field label="Rationale for deactivation">
						            <textarea 
						            	id="Rationale for deactivation" 
						            	class="textarea"
						            	rows="12"
						            	v-model="rationale"></textarea>
						        </b-field>
						    </b-field>

						    <p 
								class="help is-danger"
								:class="{ 'is-block': errors.has('deactivation_rationale') }" 
					            v-text="errors.get('deactivation_rationale')" 
					            v-show="errors.has('deactivation_rationale')"
							></p>
					    </template>

					    <template v-else>
					    	<b-field label="Reactivation date">
						        <b-datepicker
						            placeholder="Select a reactivation date..."
						            icon="calendar-today"
						            v-model="reactivatedDate">
						        </b-datepicker>
						    </b-field>

						    <p 
								class="help is-danger"
								:class="{ 'is-block': errors.has('reactivated_at') }" 
					            v-text="errors.get('reactivated_at')" 
					            v-show="errors.has('reactivated_at')"
							></p>r

						    <div style="height: 330px;"></div>
					    </template>
					</section>

					<footer class="modal-card-foot">
                        <button class="button is-info" @click.prevent="action">
                        	{{ activationAction }}
                        </button>

                        <button 
                        	class="button is-text" 
                        	type="button" 
                        	@click.prevent="close"
                        >Close</button>
                    </footer>
				</div>
			</b-modal>
		</div>
	</dd>
</template>

<script>
	import Error from '../../classes/Error'

	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		},

		data () {
			return {
				isActive: false,
				deactivatedDate: null,
				reactivatedDate: null,
				rationale: '',
				errors: new Error()
			}
		},

		computed: {
			userActiveStatus () {
				return this.user.active === 1 ? this.trans('app.general.yes') : this.trans('app.general.no')
			},

			activationAction () {
				return this.user.active === 1 ? this.trans('app.pages.users.activation.deactivate') : this.trans('app.pages.users.activation.activate')
			},

			requestAction () {
				return this.user.active === 1 ? 'post' : 'patch'
			}
		},

		methods: {
			requestData () {
				if (this.user.active === 1) {
					return {
						deactivated_at: this.deactivatedDate ? (new Date(this.deactivatedDate)).toMysqlFormat() : null,
						deactivation_rationale: this.rationale
					}
				}

				return {
					reactivated_at: (new Date(this.reactivatedDate)).toMysqlFormat()
				}
			},

			close () {
				this.isActive = false

				this.errors.clear('deactivated_at')
				this.errors.clear('reactivated_at')
				this.errors.clear('deactivation_rationale')
			},

			action () {
				let data = this.requestData()
				
				axios({
					method: this.requestAction,
					url: `${urlBase}/users/api/${this.user.id}/activation`,
					data
				}).then(({ data }) => {
					this.isActive = false

					this.$toast.open({
                        message: data.flash,
                        position: 'is-top-right',
                        type: 'is-success'
                    })

                    this.errors.clear('deactivated_at')
					this.errors.clear('reactivated_at')
					this.errors.clear('deactivation_rationale')

					setTimeout(() => {
                        window.location = `${urlBase}/users/${this.user.id}`;
                    }, 3000)
				})
				.catch(error => {
					this.errors.clear('deactivated_at')
					this.errors.clear('reactivated_at')
					this.errors.clear('deactivation_rationale')
					
					if (error.response.status === 422) {
                        this.errors.record(error.response.data.errors)
                    }
				})
			}
		}
	}
</script>