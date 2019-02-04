<template>
	<div>
		<p style="margin-bottom: 0;">Deactivated: {{ formatDate(deactivation.deactivated_at) }}</p>
		<p style="margin-bottom: 0;">Reactivated: {{ formatDate(deactivation.reactivated_at) }}</p>
		<p>Rationale: {{ deactivation.deactivation_rationale }}</p>
	</div>
</template>

<script>
	export default {
		props: {
			deactivation: {
				type: Object,
				required: true
			}
		},

		methods: {
			formatDate (date) {
				if (date === null) {
					return 'No date entered'
				}

				let dateArray = date.split(/[- :]/)

				if (dateArray.length === 3) {
					var jsDate = new Date(dateArray[0], dateArray[1]-1, dateArray[2])
				} else {
					var jsDate =  new Date(dateArray[0], dateArray[1]-1, dateArray[2], dateArray[3], dateArray[4], dateArray[5])
				}

				return `${jsDate.getDate()}/${jsDate.getMonth() + 1}/${jsDate.getFullYear()}`;
			}
		}
	}
</script>