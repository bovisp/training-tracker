<template>
	<section>
		<div v-if="errors.length" class="message is-danger mb-8">
            <div class="message-body content">
                <ul class="mt-0">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
        </div>

		<div class="level mb-8">
        	<div class="level-left">
        		<b-field>
		            <b-select v-model="perPage">
		                <option value="5">5 per page</option>
		                <option value="10">10 per page</option>
		                <option value="25">25 per page</option>
		                <option value="50">50 per page</option>
		            </b-select>
		        </b-field>
        	</div>

        	<div class="level-right" v-if="postEndpoint">
        		<button 
                    class="button is-link ml-auto self-end" 
                    @click="validate" 
                >
                    Add users
                </button>
        	</div>
        </div>

		<b-table 
			:data="records" 
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
                        class="button is-info is-small"
                    >
                        {{ meta.actionButton.text }}
                    </a>
		        </b-table-column>

		        <b-table-column 
		        	v-if="withRoles"
		        	label="Select a role..."
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
	import { forEach, map, filter, find } from 'lodash'

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
	    		errors: []
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
	        	this.errors = []

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

	        	if (this.errors.length === 0) {
	        		this.post(postArray)
	        	}
	        },

	        prepareNewUsers () {
	        	this.validateRolesModel()

	        	let postArray = []

        		forEach(this.checkedRows, user => {
        			let hasRole = false

        			forEach(filter(this.rolesModel), value => {
        				let valueArray = value.split(':')

	        			if (parseInt(valueArray[0]) == user.id) {
	        				postArray.push(valueArray)

	        				hasRole = true
	        			}
        			})

        			if (hasRole === false) {
        				this.errors.push(
        					`You have not yet assigned a role to ${user.firstname} ${user.lastname}. Please select a role from the dropdown menu.`
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

	                    this.errors.push(
	                        `You have not selected ${user.firstname} ${user.lastname} to be added, but you have selected a role. Please check the checkbox to the left of the user's name to add this person to the application`
	                    )
	        		}
	        	})
	        },

	        post (postArray) {
	        	if (postArray.length === 0) {
	                this.$toast.open({
	                    message: `Please add some users.`,
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
		                    if (error.status === 422) {
		                        window.events.$emit('users-create-error', error.data.errors)
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