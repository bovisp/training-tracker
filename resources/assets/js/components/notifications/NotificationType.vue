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
						return this.trans('app.components.notifications.newlogbookentry')

					case 'logbook_entry_updated':
						return this.trans('app.components.notifications.updatedlogbookentry')

					case 'logbook_entry_comment_updated':
						return this.trans('app.components.notifications.updatedlogbookentrycomment')

					case 'logbook_entry_comment_added':
						return this.trans('app.components.notifications.addedlogbookentrycomment')
				}
			}
		}
	}
</script>