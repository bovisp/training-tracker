<template>
	<div>
		<template v-if="!reading">
			<new-logbook-entry 
				:endpoint="endpoint"
			/>

			<logbook-entries />
		</template>

		<template v-else>
			<logbook-entry />
		</template>

		<b-loading 
			:is-full-page="true" 
			:active.sync="isLoading" 
			:can-cancel="false"
		></b-loading>
	</div>
</template>

<script>
	import NewLogbookEntry from './NewLogbookEntry'
	import LogbookEntries from './LogbookEntries'
	import LogbookEntry from './LogbookEntry'
	import { mapGetters, mapActions } from 'vuex'
	import findGetParameter from '../../mixins/findGetParameter'

	export default {
		props: {
			endpoint: {
				type: String,
				required: true
			},
			logbookId: {
				type: String,
				required: true
			},
			userId: {
				type: String,
				required: true
			}
		},

		components: {
			NewLogbookEntry,
			LogbookEntries,
			LogbookEntry
		},

		mixins: [
			findGetParameter
		],

		computed: {
			...mapGetters({
				isLoading: 'isLoading',
				entryId: 'logbooks/entryId'
			}),

			reading () {
				return this.entryId
			}
		},

		methods: {
			...mapActions({
				fetch: 'logbooks/fetch',
				setLogbookId: 'logbooks/setLogbookId',
				setUserId: 'logbooks/setUserId',
				show: 'logbooks/show'
			}),

			async init () {
				await this.fetch(this.endpoint)

				await this.setLogbookId(this.logbookId)

				await this.setUserId(this.userId)

				let logbookId = await this.findGetParameter('entry')

				if (logbookId) {
					this.show(parseInt(logbookId))
				}
			}
		},

		mounted () {
			this.init()
		}
	}
</script>