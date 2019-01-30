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

						    <b-field>
						        <b-field label="Rationale for deactivation">
						            <textarea 
						            	id="Rationale for deactivation" 
						            	class="textarea"
						            	rows="12"
						            	v-model="rationale"></textarea>
						        </b-field>
						    </b-field>
					    </template>

					    <template v-else>
					    	<b-field label="Reactivation date">
						        <b-datepicker
						            placeholder="Select a reactivation date..."
						            icon="calendar-today"
						            v-model="reactivatedDate">
						        </b-datepicker>
						    </b-field>

						    <div style="height: 330px;"></div>
					    </template>
					</section>

					<footer class="modal-card-foot">
                        <button class="button is-info" @click.prevent="action">
                        	{{ activationAction }}
                        </button>

                        <button class="button is-text" type="button" @click.prevent="isActive = false">Close</button>
                    </footer>
				</div>
			</b-modal>
		</div>
	</dd>
</template>

<script>
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
				rationale: ''
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
						deactivated_at: (new Date(this.deactivatedDate)).toMysqlFormat(),
						deactivation_rationale: this.rationale
					}
				}

				return {
					reactivated_at: (new Date(this.reactivatedDate)).toMysqlFormat()
				}
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

					setTimeout(() => {
                        window.location = `${urlBase}/users/${this.user.id}`;
                    }, 3000)
				}).catch(error => {
					console.log(error)
				})
			}
		}
	}
</script>