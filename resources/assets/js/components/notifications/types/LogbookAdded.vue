<template>
	<div>
		<span v-if="creator.id !== apprentice.id">
			{{ creatorName }} {{ trans('app.components.notifications.logbookaddedmessage1') }} {{ apprenticeName }}'s <a :href="logbookUrl">{{ trans('app.components.notifications.logbookaddedmessage2') }}</a> {{ trans('app.components.notifications.logbookaddedmessage3') }} 
		</span>

		<span v-else>
			{{ apprenticeName }} {{ trans('app.components.notifications.logbookaddedmessage4') }} <a :href="logbookUrl">{{ trans('app.components.notifications.logbookaddedmessage5') }}</a> {{ trans('app.components.notifications.logbookaddedmessage6') }} 
		</span>

		{{ trans('app.components.notifications.logbookaddedmessage7') }} "{{ objective }}" {{ trans('app.components.notifications.logbookaddedmessage8') }} <a :href="lessonPackageUrl">"{{ package }}"</a>.
	</div>
</template>

<script>
	import notificationLogbookEntry from '../../../mixins/notificationLogbookEntry'
	
	export default {
		props: {
			notification: {
				type: Object,
				required: true 
			}
		},

		mixins: [
			notificationLogbookEntry
		]
	}
</script>