<template>
	<div>
		<span v-if="editor.id !== apprentice.id">
			{{ editorName }} updated an entry in {{ apprenticeName }}'s <a :href="logbookUrl">logbook</a> for the 
		</span>

		<span v-else>
			{{ apprenticeName }} updated an entry in their <a :href="logbookUrl">logbook</a> for the 
		</span>

		objective "{{ objective }}" in lesson package <a :href="lessonPackageUrl">"{{ package }}"</a>.
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