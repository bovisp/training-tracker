<template>
	<div>
		<span v-if="editor.id !== apprentice.id">
			{{ editorName }} updated a comment in {{ apprenticeName }}'s <a :href="logbookUrl">logbook</a> for the 
		</span>

		<span v-else>
			{{ apprenticeName }} updated a comment in their <a :href="logbookUrl">logbook</a> for the 
		</span>

		objective "{{ objective }}" in lesson package <a :href="lessonPackageUrl">"{{ package }}"</a>.
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