<template>
	<div>
		<span v-if="editor.id !== apprentice.id">
			{{ editorName }} {{ trans('app.components.notifications.logbookupdatedmessage1') }} {{ apprenticeName }}'s <a :href="logbookUrl">{{ trans('app.components.notifications.logbookupdatedmessage2') }}</a> {{ trans('app.components.notifications.logbookupdatedmessage3') }} 
		</span>

		<span v-else>
			{{ apprenticeName }} {{ trans('app.components.notifications.logbookupdatedmessage4') }} <a :href="logbookUrl">{{ trans('app.components.notifications.logbookupdatedmessage5') }}</a> {{ trans('app.components.notifications.logbookupdatedmessage6') }} 
		</span>

		{{ trans('app.components.notifications.logbookupdatedmessage7') }} "{{ objective }}" {{ trans('app.components.notifications.logbookupdatedmessage8') }} <a :href="lessonPackageUrl">"{{ package }}"</a>.
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