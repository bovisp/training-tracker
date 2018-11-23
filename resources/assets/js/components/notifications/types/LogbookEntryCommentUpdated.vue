<template>
	<div>
		<span v-if="editor.id !== apprentice.id">
			{{ editorName }} {{ trans('app.components.notifications.logbookentrycommentupdatedmessage1') }} {{ apprenticeName }}'s <a :href="logbookUrl">{{ trans('app.components.notifications.logbookentrycommentupdatedmessage2') }}</a> {{ trans('app.components.notifications.logbookentrycommentupdatedmessage3') }} 
		</span>

		<span v-else>
			{{ apprenticeName }} {{ trans('app.components.notifications.logbookentrycommentupdatedmessage4') }} <a :href="logbookUrl">{{ trans('app.components.notifications.logbookentrycommentupdatedmessage5') }}</a> {{ trans('app.components.notifications.logbookentrycommentupdatedmessage6') }} 
		</span>

		{{ trans('app.components.notifications.logbookentrycommentupdatedmessage7') }} "{{ objective }}" {{ trans('app.components.notifications.logbookentrycommentupdatedmessage8') }} <a :href="lessonPackageUrl">"{{ package }}"</a>.
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