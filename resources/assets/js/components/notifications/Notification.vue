<template>
	<section>
		<notification-logbook-added 
			v-if="notification.data.data.noteType === 'logbook_entry_added'"
			:notification="notification"
		/>
	</section>
</template>

<script>
	import NotificationLogbookAdded from './types/NotificationLogbookAdded'

	export default {
		props: {
			notification: {
				type: Object,
				required: true
			}
		},

		components: {
			NotificationLogbookAdded
		}
	}
</script>