<template>
	<div>
		<div class="is-flex items-center">
			<p class="mb-0" v-if="!editingDeactivated">
				Deactivated: {{ deactivatedAt }}	
			</p>

			<template v-if="role === 'administrator'">
				<b-field v-if="editingDeactivated" class="mb-0">
			        <b-datepicker
			            :placeholder="trans('app.components.appointmentdate.select')"
			            icon="calendar-today"
			            v-model="deactivatedDate"
			            size="is-small">
			        </b-datepicker>
			    </b-field>

			    <button class="button is-text is-small ml-4" @click="editingDeactivated = true" v-if="!editingDeactivated">
			    	{{ trans('app.general.buttons.edit') }}
			    </button>

			    <template v-if="editingDeactivated">
				    <button class="button is-text is-small ml-4" @click="update">
				    	{{ trans('app.general.buttons.save') }}
				    </button>

				    <button class="button is-text is-small ml-4 has-text-danger" @click="editingDeactivated = false">
				    	{{ trans('app.general.buttons.cancel') }}
				    </button>	
			    </template>
		    </template>
		</div>

		<div class="is-flex items-center">
			<p class="mb-0" v-if="!editingReactivated">
				Reactivated: {{ reactivatedAt }}	
			</p>

			<template v-if="role === 'administrator'">
				<b-field v-if="editingReactivated" class="mb-0">
			        <b-datepicker
			            :placeholder="trans('app.components.appointmentdate.select')"
			            icon="calendar-today"
			            v-model="reactivatedDate"
			            size="is-small">
			        </b-datepicker>
			    </b-field>

			    <button class="button is-text is-small ml-4" @click="editingReactivated = true" v-if="!editingReactivated">
			    	{{ trans('app.general.buttons.edit') }}
			    </button>

			    <template v-if="editingReactivated">
				    <button class="button is-text is-small ml-4" @click="update">
				    	{{ trans('app.general.buttons.save') }}
				    </button>

				    <button class="button is-text is-small ml-4 has-text-danger" @click="editingReactivated = false">
				    	{{ trans('app.general.buttons.cancel') }}
				    </button>	
			    </template>
		    </template>
		</div>

		<div>
			<p class="mb-0" v-if="!editingRationale">
				Rationale: 	
			</p>

			<p class="mb-0" v-if="!editingRationale">
				{{ rationale }}
			</p>

			<template v-if="role === 'administrator'">
				<div class="field" v-if="editingRationale">
					<div class="control">
						<textarea class="textarea" v-model="rationale"></textarea>
					</div>
				</div>
				
				<div class="field" v-if="!editingRationale">
					<div class="control">
						<button class="button is-text is-small ml-4" @click="editingRationale = true" >
					    	{{ trans('app.general.buttons.edit') }}
					    </button>
					</div>
				</div>
			    

			    <template v-if="editingRationale">
			    	<div class="field is-grouped">
			    		<div class="control">
			    			<button class="button is-text is-small ml-4" @click="update">
						    	{{ trans('app.general.buttons.save') }}
						    </button>
			    		</div>

			    		<div class="control">
			    			 <button class="button is-text is-small ml-4 has-text-danger" @click="editingRationale = false">
					    	{{ trans('app.general.buttons.cancel') }}
					    </button>	
			    		</div>
			    	</div>
			    </template>
		    </template>
		</div>
	</div>
</template>

<script>
	import Error from '../../classes/Error'

	export default {
		props: ['user', 'role'],

		data () {
			return {
				deactivatedDate: null,
				reactivatedDate: null,
				rationale: '',
				editingRationale: null,
				editingDeactivated: false,
				editingReactivated: false,
				errors: new Error()
			}
		},

		computed: {
			deactivatedAt () {
				if (this.deactivatedDate === null) {
					return this.trans('app.components.deactivation.nodeactivateddate')
				}

				return `${this.deactivatedDate.getDate()}/${this.deactivatedDate.getMonth() + 1}/${this.deactivatedDate.getFullYear()}`;
			},

			reactivatedAt () {
				if (this.reactivatedDate === null) {
					return this.trans('app.components.deactivation.noreactivateddate')
				}

				return `${this.reactivatedDate.getDate()}/${this.reactivatedDate.getMonth() + 1}/${this.reactivatedDate.getFullYear()}`;
			}
		},

		methods: {
			update () {
				let dateData = {
					deactivated_at: this.deactivatedDate ? (new Date(this.deactivatedDate)).toMysqlFormat() : null,
					reactivated_at: this.reactivatedDate ? (new Date(this.reactivatedDate)).toMysqlFormat() : null,
					deactivation_rationale: this.rationale
				}

				axios.put(`${urlBase}/users/api/${this.user.id}/deactivation`, dateData)
					.then(({data}) => {
						this.$buefy.toast.open({
	                        message: data.flash,
	                        position: 'is-top-right',
	                        type: 'is-success'
	                    })

	                    this.editingDeactivated = false
	                    this.editingReactivated = false
	                    this.editingRationale = false

	                    this.errors.clear('deactivated_at')
	                    this.errors.clear('reactivated_at')
	                    this.errors.clear('deactivation_rationale')

	                    this.deactivatedDate = this.formatDate(data.data.deactivated_at)
	                    this.reactivatedDate = this.formatDate(data.data.reactivated_at)
	                    this.rationale = data.data.deactivation_rationale
					})
					.catch(error => {
						if (error.response.status === 422) {
	                        this.errors.record(error.data.errors)
	                    }
					})
			},

			formatDate (date) {
				let dateArray = date.split(/[- :]/)

				if (dateArray.length === 3) {
					return new Date(dateArray[0], dateArray[1]-1, dateArray[2])
				}

				return new Date(dateArray[0], dateArray[1]-1, dateArray[2], dateArray[3], dateArray[4], dateArray[5])
			}
		},

		mounted () {
			this.deactivatedDate = this.user.deactivated_at ? this.formatDate(this.user.deactivated_at) : null
			this.reactivatedDate = this.user.reactivated_at ? this.formatDate(this.user.reactivated_at) : null
			this.rationale = this.user.deactivation_rationale
		}
	}
</script>