<template>
	<b-modal :active.sync="isActive" has-modal-card>
		<div class="modal-card">
			<header class="modal-card-head">
                <p class="modal-card-title">
                	Deactivations for {{ user.firstname }} {{ user.lastname }}
                </p>
            </header>

			<section class="modal-card-body">
				<div
					v-if="isEditing"
				>
					<b-field label="Deactivation date">
				        <b-datepicker
				            icon="calendar-today"
				            v-model="editingDeactivation.deactivated_at"
				            size="is-small">
				        </b-datepicker>
				    </b-field>

				    <p 
						class="help is-danger"
						:class="{ 'is-block': errors_data.has('deactivated_at') }" 
			            v-text="errors_data.get('deactivated_at')" 
			            v-show="errors_data.has('deactivated_at')"
					></p>

				    <b-field label="Reactivation date">
				        <b-datepicker
				            icon="calendar-today"
				            v-model="editingDeactivation.reactivated_at"
				            size="is-small">
				        </b-datepicker>
				    </b-field>

				    <p 
						class="help is-danger"
						:class="{ 'is-block': errors_data.has('reactivated_at') }" 
			            v-text="errors_data.get('reactivated_at')" 
			            v-show="errors_data.has('reactivated_at')"
					></p>

				    <b-field label="Deactivation rationale">
						<div class="control">
							<textarea class="textarea" v-model="editingDeactivation.deactivation_rationale"></textarea>

							<p 
								class="help is-danger"
								:class="{ 'is-block': errors_data.has('deactivation_rationale') }" 
					            v-text="errors_data.get('deactivation_rationale')" 
					            v-show="errors_data.has('deactivation_rationale')"
							></p>
						</div>
					</b-field>

					<div class="field is-grouped">
						<div class="control">
							<button 
								class="button is-info is-small"
								@click.prevent="submit"
							>Submit</button>
						</div>

						<div class="control">
							<button 
								class="button is-text is-small"
								@click.prevent="cancel"
							>Cancel</button>
						</div>
					</div>
				</div>

				<div
					v-for="deactivation in deactivations"
					v-else
				>
					<deactivation 
						:deactivation="deactivation"
					/>

					<button 
						class="button is-text is-small"
						@click="edit(deactivation)"
					>Edit deactivation</button>

					<hr>
				</div>
			</section>

			<footer class="modal-card-foot">
                <button 
                	class="button is-text" 
                	type="button" 
                	@click.prevent="isActive = false"
                >Close</button>
            </footer>
		</div>
	</b-modal>
</template>

<script>
	import Deactivation from './Deactivation'
	import Error from '../../../classes/Error'

	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		},

		components: {
			Deactivation
		},

		data () {
			return {
				isActive: false,
				isEditing: false,
				editingDeactivation: {
					deactivated_at: '',
					reactivated_at: '',
					deactivation_rationale: ''
				},
				deactivations: [],
				errors_data: new Error()
			}
		},

		methods: {
			edit (deactivation) {
				this.isEditing = true
				this.editingDeactivation = deactivation

				this.editingDeactivation.deactivated_at = this.formatDate(this.editingDeactivation.deactivated_at)
				this.editingDeactivation.reactivated_at = this.formatDate(this.editingDeactivation.reactivated_at)
			},

			formatDate (date) {
				if (date === null) {
					return null
				}

				let dateArray = date.split(/[- :]/)

				return new Date(dateArray[0], dateArray[1]-1, dateArray[2])
			},

			submit () {
				let data = {
					deactivated_at: this.editingDeactivation.deactivated_at ? (new Date(this.editingDeactivation.deactivated_at)).toMysqlFormat() : null,
					reactivated_at: this.editingDeactivation.reactivated_at ? (new Date(this.editingDeactivation.reactivated_at)).toMysqlFormat() : null,
					deactivation_rationale: this.editingDeactivation.deactivation_rationale
				}

				axios.put(`${urlBase}/users/${this.user.id}/deactivations/${this.editingDeactivation.id}`, data)
					.then(({ data }) => {
						this.editingDeactivation.deactivated_at = ''
						this.editingDeactivation.deactivation_rationale = ''
						this.editingDeactivation.reactivated_at = ''

						this.isEditing = false

						this.errors_data.clear('deactivated_at')
						this.errors_data.clear('reactivated_at')
						this.errors_data.clear('deactivation_rationale')

						window.events.$emit('user:activation', data.active)

						this.$toast.open({
	                        message: data.flash,
	                        position: 'is-top-right',
	                        type: 'is-success'
	                    })

						this.fetch()
					})
					.catch(error => {
						this.errors_data.clear('deactivated_at')
						this.errors_data.clear('reactivated_at')
						this.errors_data.clear('deactivation_rationale')
						
						if (error.response.status === 422) {
	                        this.errors_data.record(error.response.data.errors)
	                    }
					})
			},

			cancel () {
				this.editingDeactivation.deactivated_at = ''
				this.editingDeactivation.deactivation_rationale = ''
				this.editingDeactivation.reactivated_at = ''

				this.isEditing = false

				this.fetch()
			},

			fetch () {
				axios.get(`${urlBase}/users/${this.user.id}/deactivations`)
					.then(({ data }) => {
						this.deactivations = data.data
					})
			}
		},

		mounted () {
			window.events.$on('deactivation-model:toggle', () => this.isActive = true)

			this.fetch()
		}
	}
</script>