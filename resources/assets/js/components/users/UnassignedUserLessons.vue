<template>
	<div v-cloak>
		<div v-if="!editingNonDepricated && !editingDepricated">
			<button 
				v-if="unassigned.non_depricated.length"
				class="button is-link is-small"
				@click="editingNonDepricated = true"
			>
				{{ trans('app.components.unassigneduserlessons.addnewpackage') }}
			</button>

			<button 
				v-if="unassigned.depricated.length"
				class="button is-link is-small ml-4"
				@click="editingDepricated = true"
			>
				{{ trans('app.components.unassigneduserlessons.adddepricatedpackage') }}
			</button>
		</div>

		<div v-if="unassigned.non_depricated.length && editingNonDepricated">
			<div class="select is-small" 
				:class="{ 'is-danger': errors.has('userlesson') }"
			>
				<select v-model="nonDepricated">
					<option value="" selected>
						{{ trans('app.components.unassigneduserlessons.choosepackage') }}
					</option>

					<option 
						:value="lesson.id" 
						v-for="lesson in nonDepricatedLessons"
						:key="lesson.id"
					>
						{{ lesson.number }} - {{ lesson.name }}
					</option>
				</select>
			</div>

			<button 
				class="button is-link is-small ml-4"
				@click="submit(nonDepricated)"
			>
				{{ trans('app.components.unassigneduserlessons.addpackage') }}
			</button>

			<button 
				class="button is-text has-text-danger is-small ml-4"
				@click="editingNonDepricated = false"
			>
				{{ trans('app.general.buttons.cancel') }}
			</button>

			<div 
                class="help is-danger" 
                v-text="errors.get('userlesson')" 
                v-show="errors.has('userlesson')"
            ></div>
		</div>

		<div v-if="unassigned.depricated.length && editingDepricated">
			<div class="select is-small" 
				:class="{ 'is-danger': errors.has('userlesson') }"
			>
				<select v-model="depricated">
					<option value="" selected>
						{{ trans('app.components.unassigneduserlessons.choosepackage') }}
					</option>

					<option 
						:value="lesson.id" 
						v-for="lesson in depricatedLessons"
						:key="lesson.id"
					>
						{{ lesson.number }} - {{ lesson.name }}
					</option>
				</select>
			</div>

			<button 
				class="button is-link is-small ml-4"
				@click="submit(depricated)"
			>
				{{ trans('app.components.unassigneduserlessons.addpackage') }}
			</button>

			<button 
				class="button is-text has-text-danger is-small ml-4"
				@click="editingDepricated = false"
			>
				{{ trans('app.general.buttons.cancel') }}
			</button>

			<div 
                class="help is-danger" 
                v-text="errors.get('userlesson')" 
                v-show="errors.has('userlesson')"
            ></div>
		</div>
	</div>
</template>

<script>
	import Error from "../../classes/Error"

	export default {
		props: ['userId'],

		data () {
			return {
				unassigned: {
					depricated: [],
					non_depricated: []
				},
				nonDepricated: '',
				editingNonDepricated: false,
				depricated: '',
				editingDepricated: false,
				errors: new Error()
			}
		},

		methods: {
			fetch () {
				axios.get(`${urlBase}/users/${this.userId}/userlessons/unassigned`)
					.then(({data}) => {
						this.unassigned.non_depricated = data.non_depricated || []
						this.unassigned.depricated = data.depricated || []
					})
			},

			submit (lesson) {
				if (lesson !== '') {
					axios.interceptors.response.use(
		                response => {
		                  return response;
		                },
		                error => {
		                    return Promise.reject(error.response);
		                }
		            )

					axios.post(`${urlBase}/users/${this.userId}/userlessons/unassigned`, {
						userlesson: lesson
					})
						.then(response => {
							this.nonDepricated = ''

							this.$toast.open({
		                        message: response.data.flash,
		                        position: 'is-top-right',
		                        type: 'is-success'
		                    })

							setTimeout(() => {
								window.location = `/users/${this.userId}`
							}, 3000)
						})
						.catch(error => {
		                    if (error.status === 422) {
		                        this.errors.record(error.data.errors);
		                    }
		                })
				}
			}
		},

		computed: {
			nonDepricatedLessons () {
				let self = this

				return orderBy(self.unassigned.non_depricated, ['number'], ['asc'])
			},

			depricatedLessons () {
				let self = this

				return orderBy(self.unassigned.depricated, ['number'], [ 'asc'])
			}
		},

		mounted () {
			this.fetch()
		}
	}
</script>