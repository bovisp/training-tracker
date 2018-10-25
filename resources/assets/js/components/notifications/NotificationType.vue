<template>
	<p>{{ typeString }}</p>
</template>

<script>
	export default {
		props: {
			type: {
				type: String,
				required: true
			}
		},

		computed: {
			typeString () {
				switch (this.type) {
					case 'logbook_entry_added':
						return 'New logbook entry'

					case 'logbook_entry_updated':
						return 'Updated logbook entry'

					case 'logbook_entry_comment_updated':
						return 'Updated logbook entry comment'

					case 'logbook_entry_comment_added':
						return 'Logbook entry comment added'
				}
			}
		}
	}
</script>