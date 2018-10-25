<template>
	<div class="content">
		<logbook-added 
			:notification="notification"
			v-if="notification.data.data.noteType === 'logbook_entry_added'"
		/>

		<logbook-updated 
			:notification="notification"
			v-if="notification.data.data.noteType === 'logbook_entry_updated'"
		/>
	</div>
</template>

<script>
	import LogbookAdded from './types/LogbookAdded'
	import LogbookUpdated from './types/LogbookUpdated'

	export default {
		props: {
			notification: {
				type: Object,
				required: true 
			}
		},

		components: {
			LogbookAdded,
			LogbookUpdated
		}
	}
</script>