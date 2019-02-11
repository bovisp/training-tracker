<template>
	<div class="column" :class="{ 'has-background-grey-lighter': isCovered }">
		<div class="field">
			<label 
				v-text="label" 
				:id="status" 
				class="label"
			></label>

			<div class="control">
				<div 
					class="select is-full-width" 
					:class="{ 'is-danger': errors[`statuses.${status}`] }"
				>
			        <select 
			        	@change="handleInput" 
			        	:for="status" 
			        	class="is-full-width"
			        	:disabled="!hasRoleOf(['supervisor', 'head_of_operations']) || disableItem"
			        >
			        	<option 
			        		:value="null"
			        	></option>

			            <option
			                 v-for="statusType in statusTypes"
			                :value="statusType.type"
			                :key="statusType.type"
			                :selected="statusType.type === content"
			            >{{ statusType.name }}</option>
			        </select>
		        </div>
	        </div>

	        <p 
				v-if="errors[`statuses.${status}`]" 
				v-text="errors[`statuses.${status}`][0]"
				class="help is-danger"
			></p>
	    </div>
    </div>
</template>

<script>
	export default {
		props: ['status'],

		data () {
		    return {
		    	isCovered: 0,
		    	label: '',
		    	content: null,
		    	disableItem: false,
		    	statusTypes: [
					{ type: 'c', name: 'C - Completed' },
					{ type: 'd', name: 'D - Deferred' },
					{ type: 'e', name: 'E - Exempt' }
				]
		    }
		},

		methods: {
			handleInput (e) {
				this.$emit('statuschanged', {
					status: this.status,
					value: e.target.value
				})
			}
		},

		mounted () {
			window.events.$on(`status-${this.status}`, ({ period, isCovered, statusLabel }) => {
				this.content = period
				this.isCovered = isCovered
				this.label = statusLabel
			})

			window.events.$on('disable', disabled => {
				if (disabled === 0 || disabled === '0') {
					this.disableItem = false
				} else if (disabled === 1 || disabled === '1') {
					this.disableItem = true
				}
			})
		}
	}
</script>