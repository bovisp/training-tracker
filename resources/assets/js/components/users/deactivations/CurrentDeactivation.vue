<template>
	<div>
		<p style="margin-bottom: 0;">Deactivated: {{ deactivated_at }}</p>
		<p style="margin-bottom: 0;">Reactivated: {{ reactivated_at }}</p>
		<p>Rationale: {{ deactivation_rationale }}</p>
	</div>
</template>

<script>
	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		},

		data () {
			return {
				deactivated_at: null,
				reactivated_at: null,
				deactivation_rationale: ''
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
		},

		created () {
			this.deactivated_at = this.formatDate(this.user.deactivations[0].deactivated_at)
			this.reactivated_at = this.formatDate(this.user.deactivations[0].reactivated_at)
			this.deactivation_rationale = this.user.deactivations[0].deactivation_rationale
		}
	}
</script>