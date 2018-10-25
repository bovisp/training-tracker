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
				}
			}
		}
	}
</script>