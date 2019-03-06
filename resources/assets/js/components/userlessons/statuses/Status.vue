<template>
	<div class="column" :class="{ 'has-background-grey-lighter': isCovered }">
		<div class="field">
			<label 
				v-text="status.name" 
				:for="status.period" 
				class="label"
			></label>

			<div class="control">
				<div 
					class="select is-full-width"
				>
			        <select 
			        	:id="status.period" 
			        	:value="periodValue"
			        	@input="update"
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
			                :selected="statusType.type === periodValue"
			            >{{ statusType.name }}</option>
			        </select>
		        </div>
	        </div>
	    </div>
    </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {
		props: {
			status: {
				type: Object,
				required: true
			}
		},

		data () {
			return {
				periods: ['p9', 'p18', 'p30', 'p42']
			}
		},

		computed: {
			...mapGetters({
				lesson: 'userlessons/lesson',
				statusTypes: 'userlessons/statusTypes',
				allObjectivesComplete: 'userlessons/allObjectivesComplete',
				form: 'userlessons/form'
			}),

			periodValue () {
				console.log(this.form.statuses[this.status.period])
				return this.form.statuses[this.status.period]
			},

			isCovered () {
				return this.lesson[this.status.period]
			},

			filteredStatusTypes () {
				if (this.allObjectivesComplete) {
					let statusArr = [
						this.lesson['p9'],
						this.lesson['p18'],
						this.lesson['p30'],
						this.lesson['p42']
					]

					let statusIndex = _.indexOf(this.periods, this.status.period)

					if (statusIndex === 0 && _.indexOf(statusArr, 1, statusIndex + 1) >= 0) {
						return filter(this.statusTypes, status => status.type !== 'c')
					}

					if (statusIndex === 0 && _.indexOf(statusArr, 1, statusIndex + 1) === -1) {
						return this.statusTypes
					}	

					if (this.status.period === 'p42') {
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
			...mapActions({
				updateStatus: 'userlessons/updateStatus'
			}),

			update (e) {
				this.updateStatus({
					period: this.status.period,
					value: e.target.value
				})
			}
		}
	}
</script>