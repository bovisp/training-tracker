<template>
	<div>
		<div class="is-flex items-center">
			<p class="mb-0" v-if="!editing">
				{{ appointedAt }}	
			</p>

			<template v-if="role === 'administrator'">
				<b-field v-if="editing" class="mb-0">
			        <b-datepicker
			            :placeholder="trans('app.components.appointmentdate.select')"
			            icon="calendar-today"
			            v-model="appointmentDate"
			            size="is-small">
			        </b-datepicker>
			    </b-field>

			    <button class="button is-text is-small ml-4" @click="editing = true" v-if="!editing">
			    	{{ trans('app.general.buttons.edit') }}
			    </button>

			    <template v-if="editing">
				    <button class="button is-text is-small ml-4" @click="update">
				    	{{ trans('app.general.buttons.save') }}
				    </button>

				    <button class="button is-text is-small ml-4 has-text-danger" @click="editing = false">
				    	{{ trans('app.general.buttons.cancel') }}
				    </button>	
			    </template>
		    </template>
		</div>

		<div v-if="editing">
			<p 
				class="help is-danger"
				:class="{ 'is-block': errors_data.has('appointed_at') }" 
	            v-text="errors_data.get('appointed_at')" 
	            v-show="errors_data.has('appointed_at')"
			></p>
		</div>
	</div>
</template>

<script>
	import Error from '../../classes/Error'

	export default {
		props: ['user', 'role'],

		data () {
			return {
				appointmentDate: '',
				editing: false,
				errors_data: new Error()
			}
		},

		computed: {
			appointedAt () {
				if (this.appointmentDate === null) {
					return this.trans('app.components.appointmentdate.noappointmentset')
				}

        let date = new Date(this.appointmentDate)

				return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
			}
		},

		methods: {
			update () {
				axios.put(`${urlBase}/users/api/${this.user.id}/appointment`, {
					appointed_at: (new Date(this.appointmentDate)).toMysqlFormat()
				})
					.then(({data}) => {
						this.$toast.open({
	                        message: data.flash,
	                        position: 'is-top-right',
	                        type: 'is-success'
	                    })

	                    this.editing = false

	                    this.errors_data.clear('appointed_at')

	                    console.log(data.date.date)

	                    this.appointmentDate = new Date(data.date.date)
					})
					.catch(error => {
						if (error.response.status === 422) {
	                        this.errors_data.record(error.data.errors)
	                    }
					})
			},

			formatDate (date) {
        let dateArray = date.split('/')
        console.log(dateArray)

				return new Date(`${dateArray[1]}-${dateArray[0]}-${dateArray[2]}`)
			}
		},

		mounted () {
			this.appointmentDate = this.user.appointed_at ? this.formatDate(this.user.appointed_at) : null
		}
	}
</script>