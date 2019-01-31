<template>
	<b-modal :active.sync="isActive" has-modal-card>
		<div class="modal-card">
			<header class="modal-card-head">
                <p class="modal-card-title">
                	Deactivations for {{ user.firstname }} {{ user.lastname }}
                </p>
            </header>

			<section class="modal-card-body">
				<div
					v-for="deactivation in user.deactivations"
				>
					<p style="margin-bottom: 0;">Deactivated: {{ formatDate(deactivation.deactivated_at) }}</p>
					<p style="margin-bottom: 0;">Reactivated: {{ formatDate(deactivation.reactivated_at) }}</p>
					<p>Rationale: {{ deactivation.deactivation_rationale }}</p>

					<hr>
				</div>
			</section>

			<footer class="modal-card-foot">
                <button 
                	class="button is-text" 
                	type="button" 
                	@click.prevent="isActive = false"
                >Close</button>
            </footer>
		</div>
	</b-modal>
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
				isActive: false
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

		mounted () {
			window.events.$on('deactivation-model:toggle', () => this.isActive = true)
		}
	}
</script>