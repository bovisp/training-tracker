<template>
	<section>
		<notification-logbook-added 
			v-if="notification.data.noteType === 'logbook_entry_added'"
			:notification="notification"
			:user="user"
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
			},
			user: {
				type: Object,
				required: true
			}
		},

		components: {
			NotificationLogbookAdded
		}
	}
</script>