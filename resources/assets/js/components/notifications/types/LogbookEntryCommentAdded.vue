<template>
	<div>
		<span v-if="creator.id !== apprentice.id">
			{{ creatorName }} added a new comment in {{ apprenticeName }}'s <a :href="logbookUrl">logbook</a> for the 
		</span>

		<span v-else>
			{{ apprenticeName }} added a new comment in their <a :href="logbookUrl">logbook</a> for the 
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