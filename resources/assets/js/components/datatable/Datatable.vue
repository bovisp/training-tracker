<template>
	<div>
        <!-- <div v-if="errors.length" class="message is-danger">
            <div class="message-body content">
                <ul class="mt-0">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
        </div> -->
        <p>A list of names that rhyme: {{recordsModel.join(', ')}}</p>


		<table id="table">
			<thead>
				<tr>
					<th v-if="hasCheckbox">&nbsp;</th>

					<th 
						v-for="header in meta.displayable" 
						:key="header.key"
						v-text="header.title"
					></th>

					<th v-if="hasButton">&nbsp;</th>
				</tr>
			</thead>

			<tbody>
				<tr v-for="record in sortedRecords" :key="record.id">
					<td v-if="hasCheckbox">
                        <input 
                            type="checkbox" 
                            :value="record.id"
                            v-model="recordsModel"
                        >
                    </td>

					<td v-for="item in meta.displayable">
						{{ record[item.key] }}
					</td>

					<td v-if="hasButton">
	                    <a 
	                        :href="actionButtonLink(record.id)"
	                        class="button is-info is-small"
	                    >
	                        {{ meta.actionButton.text }}
	                    </a>
	                </td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	import DataTable from 'vanilla-datatables'

	export default {
		props: {
			endpoint: {
				required: true,
				type: String
			},
			hasCheckbox: {
				required: false,
				type: Boolean
			}
		},

	    data () {
	    	return {
	    		records: [],
	    		meta: {
	    			actionButton: {},
	    			displayable: [],
	    			orderby: [],
	    			roles: []
	    		},
	    		order: {
	    			keys: [],
	    			dir: []
	    		},
	    		recordsModel: []
	    	}
	    },

	    watch: {
	    	selected () {
	    		console.log('abc')
	    	}
	    },

	    computed: {
	    	hasButton () {
	    		return this.meta.actionButton.active
	    	},

	    	sortedRecords () {
	    		let self = this
	    		
	    		return _.orderBy(self.records, self.order.keys, self.order.dir)
	    	}
	    },

	    methods: {
	    	async fetch () {
	    		await axios.get(this.endpoint)
	    			.then(({data}) => {
	    				this.records = data.records
	    				this.meta = data.meta
	    			})

	 			await this.setOrder()

	    		const dataTable = new DataTable("#table")	
	    	},

	    	actionButtonLink(id) {
	            return `
	                ${this.meta.actionButton.endpoint}${id}${this.meta.actionButton.endpointSuffix || ''}
	            `
	        },

	        setOrder () {
	        	let self = this

	        	_.forEach(self.meta.orderby, (item) => {
	        		self.order.keys.push(item.key)
	        		self.order.dir.push(item.dir)
	        	})
	        }
	    },

	    mounted () {
	    	this.fetch()
	    }
	}
</script>