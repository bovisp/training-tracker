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
			        	:disabled="!hasRoleOf(['supervisor', 'head_of_operations'])"
			        >
			        	<option 
			        		:value="null"
			        	></option>

			            <option
			                 v-for="statusType in filteredStatusTypes"
			                :value="statusType.type"
			                :key="statusType.type"
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
	import { mapGetters } from 'vuex'

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
				],
				allObjectivesCompleted: false,
				periods: ['p9', 'p18', 'p30', 'p42']
		    }
		},

		computed: {
			...mapGetters({
				userlesson: 'userlessons/userlesson'
			}),

			hasLesson () {
				return typeof this.userlesson.lesson !== 'undefined' && Object.keys(this.userlesson.lesson).length > 0
			},

			filteredStatusTypes () {
				if (this.allObjectivesCompleted && this.hasLesson) {
					let statusArr = [
						this.userlesson.lesson['p9'],
						this.userlesson.lesson['p18'],
						this.userlesson.lesson['p30'],
						this.userlesson.lesson['p42']
					]

					let statusIndex = _.indexOf(this.periods, this.status)

					console.log(statusIndex)

					if (statusIndex === 0 && _.indexOf(statusArr, 1, statusIndex + 1) >= 0) {
						return filter(this.statusTypes, status => status.type !== 'c')
					}

					if (statusIndex === 0 && _.indexOf(statusArr, 1, statusIndex + 1) === -1) {
						return this.statusTypes
					}

					if (this.status === 'p42') {
						return this.statusTypes
					}

					if (statusArr[statusIndex] === 1 && _.indexOf(statusArr, 1, statusIndex + 1) >= 0) {
						return filter(this.statusTypes, status => status.type !== 'c')
					}

					if (statusArr[statusIndex] === 0 && _.indexOf(statusArr, 1, statusIndex + 1) >= 0 && _.lastIndexOf(statusArr, 0, statusIndex - 1) >= 0) {
						return filter(this.statusTypes, status => status.type !== 'c')
					}

					if (statusArr[statusIndex] === 0 && _.indexOf(statusArr, 0, statusIndex + 1) >= 0 && _.lastIndexOf(statusArr, 1, statusIndex - 1) >= 0) {
						return this.statusTypes
					}

					if (statusArr[statusIndex] === 1 && _.indexOf(statusArr, 1, statusIndex + 1) >= 0 && _.lastIndexOf(statusArr, 1, statusIndex - 1) >= 0) {
						return filter(this.statusTypes, status => status.type !== 'c')
					}

					if (statusArr[statusIndex] === 1 && _.indexOf(statusArr, 1, statusIndex + 1) === -1) {
						return this.statusTypes
					}
				}
				
				return filter(this.statusTypes, status => status.type !== 'c')
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

			window.events.$on('objectivescompleted', completed => this.allObjectivesCompleted = completed)
		}
	}
</script>