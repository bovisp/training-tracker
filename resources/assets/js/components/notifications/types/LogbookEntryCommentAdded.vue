<template>
	<div>
		<span v-if="creator.id !== apprentice.id">
			{{ creatorName }} {{ trans('app.components.notifications.logbookentrycommentaddedmessage1') }} {{ apprenticeName }}'s <a :href="logbookUrl">{{ trans('app.components.notifications.logbookentrycommentaddedmessage2') }}</a> {{ trans('app.components.notifications.logbookentrycommentaddedmessage3') }} 
		</span>

		<span v-else>
			{{ apprenticeName }} {{ trans('app.components.notifications.logbookentrycommentaddedmessage4') }} <a :href="logbookUrl">{{ trans('app.components.notifications.logbookentrycommentaddedmessage5') }}</a> {{ trans('app.components.notifications.logbookentrycommentaddedmessage6') }} 
		</span>

		{{ trans('app.components.notifications.logbookentrycommentaddedmessage7') }} "{{ objective }}" {{ trans('app.components.notifications.logbookentrycommentaddedmessage8') }} <a :href="lessonPackageUrl">"{{ package }}"</a>.
	</div>
</template>

<script>
	import notificationLogbookCommentEntry from '../../../mixins/notificationLogbookCommentEntry'
	
	export default {
		props: {
			notification: {
				type: Object,
				required: true 
			}
		},

		mixins: [
			notificationLogbookCommentEntry
		]
	}
</script>