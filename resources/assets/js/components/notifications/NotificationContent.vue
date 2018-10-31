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

		<logbook-entry-comment-added 
			:notification="notification"
			v-if="notification.data.data.noteType === 'logbook_entry_comment_added'"
		/>

		<logbook-entry-comment-updated 
			:notification="notification"
			v-if="notification.data.data.noteType === 'logbook_entry_comment_updated'"
		/>
	</div>
</template>

<script>
	import LogbookAdded from './types/LogbookAdded'
	import LogbookUpdated from './types/LogbookUpdated'
	import LogbookEntryCommentAdded from './types/LogbookEntryCommentAdded'
	import LogbookEntryCommentUpdated from './types/LogbookEntryCommentUpdated'

	export default {
		props: {
			notification: {
				type: Object,
				required: true 
			}
		},

		components: {
			LogbookAdded,
			LogbookUpdated,
			LogbookEntryCommentAdded,
			LogbookEntryCommentUpdated
		}
	}
</script>