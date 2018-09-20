<template>
	<div>
		<article v-if="errors['denied']" class="message is-danger mt-4">
			<div class="message-body content">
				<ul class="mt-0">
					<li v-for="(error, type) in errors" v-text="error" :key="type"></li>
				</ul>
			</div>
		</article>

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

		<user-lesson-objectives v-if="!isLoading"></user-lesson-objectives>

		<user-lesson-notebooks v-if="!isLoading"></user-lesson-notebooks>

		<h3 class="title is-3 mt-16">
			Comments
		</h3>

		<comments :endpoint="commentEndpoint" />

		<h3 class="title is-3 mt-16">
			Final evaluation
		</h3>
	</div>
</template>

<script>
	import { mapState, mapActions } from 'vuex'
	import UserLessonStatus from './UserLessonStatus'
	import UserLessonObjectives from './UserLessonObjectives'
	import UserLessonNotebooks from './UserLessonNotebooks'

	export default {
		props: ['userLesson', 'user'],

		components: {
			UserLessonStatus,
			UserLessonObjectives,
			UserLessonNotebooks
		},

		data () {
			return {
				formData: {},
				errors: {}
			}
		},

		computed: {
			...mapState({
				status: state => state.userlesson.status,
				isLoading: state => state.isLoading
			}),

			commentEndpoint () {
				return `/users/${this.user.id}/userlessons/${this.userLesson.id}/comments`
			}
		},

		methods: {
			submit () {
				this.$store.dispatch('userlessons/updateLessonPackage')
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
						 	window.events.$emit('status-errors', error.data.errors)
						 	window.events.$emit('objective-errors', error.data.errors)
	                    }

	                    if (error.status === 403) {
						 	this.errors = error.data.errors.errors
	                    }
					})
			},
			...mapActions({
				fetch: 'userlessons/loadState'
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