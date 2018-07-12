<template>
	<div>
		<div class="columns">
			<div class="column">
				<button 
					class="button is-link is-pulled-right"
					:class="{ 'is-loading' : isLoading }"
					@click="submit"
				>
					Save lesson package
				</button>
			</div>
		</div>

		<user-lesson-status v-if="!isLoading"></user-lesson-status>
	</div>
</template>

<script>
	import { mapState, mapActions } from 'vuex'

	export default {
		props: ['userLesson', 'user'],

		data () {
			return {
				formData: {}
			}
		},

		computed: {
			...mapState({
				status: state => state.userlesson.status,
				isLoading: state => state.isLoading
			})
		},

		methods: {
			submit () {
				this.formData = {
					// statuses: this.status
					statuses: {
						p9: 'p'
					}
				}

				this.$store.dispatch('updateLessonPackage', this.formData)
					.then(({data}) => {
						this.$toast.open({
	                        message: data.flash,
	                        position: 'is-top-right',
	                        type: 'is-success'
	                    })

						this.fetch({
							userlesson: this.userLesson.id,
							user: this.user.id
						})
					})
					.catch(error => {
						 if (error.status === 422) {
						 	this.$store.commit('loadStatus', false)

						 	window.events.$emit('status-errors', error.data.errors)
	                    }
					})
			},
			...mapActions({
				fetch: 'loadState'
			})
		},

		mounted () {
			this.fetch({
				userlesson: this.userLesson.id,
				user: this.user.id
			})
		}
	}
</script>