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
				setUserId: 'logbooks/setUserId'
			})
		},

		mounted () {
			this.fetch(this.endpoint)

			this.setLogbookId(this.logbookId)

			this.setUserId(this.userId)
		}
	}
</script>