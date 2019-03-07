<template>
	<section>
		<div v-if="errors_data.length" class="message is-danger mb-8">
            <div class="message-body content">
                <ul class="mt-0">
                    <li v-for="error in errors_data" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

		<div class="columns">
			<div class="column" v-if="postEndpoint">
				<div class="is-flex">
					<button 
	                    class="button is-link ml-auto self-end" 
	                    @click="validate" 
	                >
	                    {{ trans('app.components.datatable.addusers') }}
	                </button>
                </div>
			</div>
		</div>

		<div class="columns">
			<div class="column is-half">
				<b-field>
		            <b-select v-model="perPage" expanded>
		                <option value="5">{{ trans('app.components.datatable.fiveperpage') }}</option>
		                <option value="10">{{ trans('app.components.datatable.tenperpage') }}</option>
		                <option value="25">{{ trans('app.components.datatable.twentyfiveperpage') }}</option>
		                <option value="50">{{ trans('app.components.datatable.fiftyperpage') }}</option>
		                <option value="100">{{ trans('app.components.datatable.hundredperpage') }}</option>
		            </b-select>
		        </b-field>
			</div>

			<div class="column is-half">
				<b-field>
		            <b-input :placeholder="trans('app.components.datatable.search')"
		                type="search"
		                icon="magnify"
		                v-model="search">
		            </b-input>
		        </b-field>
			</div>
		</div>

		<b-table 
			:data="filteredRecords" 
			:mobile-cards="true"
			:loading="isLoading"
			:paginated="true"
			:per-page="perPage"
			:pagination-simple="false"
			:checkable="hasCheckbox"
			:checked-rows.sync="checkedRows"
		>
			<template slot-scope="props">
				<b-table-column 
					v-for="column in meta.displayable"
					:key="column.field"
					:field="column.field" 
					:label="column.label"
					:sortable="column.sortable"
				>
		            {{ props.row[column.field] }}
		        </b-table-column>

		        <b-table-column 
		        	v-if="meta.actionButton.active"
		        	label=""
		        >
		        	<a 
                        :href="actionButtonLink(props.row.id)"
                        class="button is-text has-text-info"
                    >
                        {{ meta.actionButton.text }}
                    </a>
		        </b-table-column>

		        <b-table-column 
		        	v-if="withRoles"
		        	:label="trans('app.components.datatable.selectrole')"
		        >
                    <div class="select">
                        <select v-model="rolesModel[props.row.id]">
                            <option value=""></option>

                            <option 
                                :value="`${props.row.id}:${role.type}`" 
                                v-for="role in roles" 
                                :key="role.id"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                    </div>
                </b-table-column>
	    	</template>
		</b-table>
	</section>
</template>

<script>
	import sort from 'fast-sort'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			},
			hasCheckbox: {
				required: false,
				type: Boolean
			},
			withRoles: {
	            type: Boolean,
	            required: false
	        },
	        postEndpoint: {
	            type: String,
	            required: false
	        },
		    successMessage: {
	            type: String,
	            required: false
	        },
	        redirectEndpoint: {
	            type: String,
	            required: false
	        }
		},

		data () {
			return {
				records: [],

	    		meta: {
	    			actionButton: {},
	    			displayable: [],
	    			orderby: [],
	    		},
	    		isLoading: false,
	    		perPage: 10,
	    		sortOrder: [],
	    		checkedRows: [],
	    		roles: [],
	    		rolesModel: [],
	    		errors_data: [],
	    		search: ''
			}
		},

		computed: {
			filteredRecords () {
				let data = this.records

				data = filter(data, row => {
					return Object.keys(row).some(key => {
						return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1
					})
				})

				return data
			}
		},

		methods: {
			async fetch () {
				this.isLoading = !this.isLoading

				await axios.get(this.endpoint)
	    			.then(({data}) => {
	    				this.records = data.records
	    				this.meta = data.meta

	    				if (data.roles) {
	    					this.roles = data.roles
	    				}

	    				if (data.linkUsers) {
	    					this.populateCheckedUsers()
	    				}
	    			})

	    		await this.makeSortArray()

	    		await sort(this.records).by(this.sortOrder)

	    		this.isLoading = !this.isLoading
			},

			makeSortArray () {
				forEach(this.meta.orderby, item => {
					this.sortOrder.push({
						[item.dir]: item.key
					})
				})
			},

			actionButtonLink (id) {
	            return `
	                ${this.meta.actionButton.endpoint}${id}${this.meta.actionButton.endpointSuffix || ''}
	            `
	        },

	        validate () {
	        	this.errors_data = []

	        	let postArray = []

	        	if (this.withRoles) {
	        		postArray = this.prepareNewUsers()
	        	} else {
	        		postArray = map(this.checkedRows, user => {
	        			return {
	        				id: user.id
	        			}
	        		})
	        	}

	        	if (this.errors_data.length === 0) {
	        		this.post(postArray)
	        	}
	        },

	        prepareNewUsers () {
	        	this.validateRolesModel()

	        	let postArray = []

        		forEach(this.checkedRows, user => {
        			let hasRole = false

        			forEach(filter(this.rolesModel), value => {
        				let tempArray = value.split(':')

        				let valueArray = {
        					id: tempArray[0],
        					role: tempArray[1]
        				}

	        			if (parseInt(tempArray[0]) == user.id) {
	        				postArray.push(valueArray)

	        				hasRole = true
	        			}
        			})

        			if (hasRole === false) {
        				this.errors_data.push(
        					`${this.trans('app.components.datatable.roleerrormessage1')} ${user.firstname} ${user.lastname}. ${this.trans('app.components.datatable.roleerrormessage2')}`
        				)
        			}
        		})

        		return postArray
	        },

	        validateRolesModel () {
	        	forEach(filter(this.rolesModel), value => {
	        		let valueArray = value.split(':')

	        		if (find(this.checkedRows, ['id', parseInt(valueArray[0])]) === undefined) {
	        			const user = this.findUserId(parseInt(valueArray[0]))

	                    this.errors_data.push(
	                        `${this.trans('app.components.datatable.roleerrormessage3')} ${user.firstname} ${user.lastname} ${this.trans('app.components.datatable.roleerrormessage4')}`
	                    )
	        		}
	        	})
	        },

	        post (postArray) {
	        	if (postArray.length === 0) {
	                this.$toast.open({
	                    message: `${this.trans('app.components.datatable.usererror')}`,
	                    position: 'is-top-right',
	                    type: 'is-danger'
	                })
	            } else {
	            	axios.post(this.postEndpoint, postArray)
		                .then(response => {
		                    this.$toast.open({
		                        message: this.successMessage,
		                        position: 'is-top-right',
		                        type: 'is-success'
		                    })

		                    setTimeout(() => {
		                        window.location = this.redirectEndpoint;
		                    }, 3000)
		                })
		                .catch(error => {
		                    if (error.response.status === 422) {
		                        window.events.$emit('users-create-error', error.response.data.errors)
		                    }
		                })
	            }
	        },

	        findUserId (key) {
	        	return find(this.records, ['id', key])
	        },

	        populateCheckedUsers () {
	        	forEach(this.records, user => {
	        		if (user.checked) {
	        			this.checkedRows.push(user)
	        		}
	        	})
	        }
		},

		mounted () {
			this.fetch()
		}
	}
</script>