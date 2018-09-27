<template>
	<div>
		<article v-if="errors.denied" class="message is-danger mt-4">
			<div class="message-body content">
				<ul class="mt-0">
					<li v-for="(error, type) in errors" v-text="error" :key="type"></li>
				</ul>
			</div>
		</article>

		<div 
			class="columns" 
			v-if="hasRoleOf('supervisor', 'head_of_operations', 'manager')"
		>
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

		<user-lesson-status />

		<user-lesson-objectives />

		<!-- <user-lesson-notebooks></user-lesson-notebooks> -->

		<h3 class="title is-3 mt-16">
			Comments
		</h3>

		<comments 
			:endpoint="commentsEndpoint"
		/>

		<h3 class="title is-3 mt-16">
			Final evaluation
		</h3>

		<b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
	</div>
</template>

<script>
	import UserLessonStatus from './UserLessonStatus'
	import UserLessonObjectives from './UserLessonObjectives'
	// import UserLessonNotebooks from './UserLessonNotebooks'
	import Comments from '../comments/Comments'
	import { mapGetters, mapActions } from 'vuex'

	export default {
		props: ['userLesson', 'user'],

		computed: {
			...mapGetters({
				isLoading: 'isLoading',
				errors: 'errors'
			}),

			commentsEndpoint () {
				return `/users/${this.user.id}/userlessons/${this.userLesson.id}/comments`
			}
		},

		components: {
			UserLessonStatus,
			UserLessonObjectives,
			// UserLessonNotebooks,
			Comments
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetch',
				patch: 'userlessons/patch'
			}),

			submit () {
				this.patch()
					.then(response => this.$toast.open({
			                message: response.data.flash,
			                position: 'is-top-right',
			                type: 'is-success'
            		})).catch(error => {
						if (error.response.status === 403) {
							this.$dialog.alert({
			                    title: 'Unauthorized',
			                    message: error.denied,
			                    type: 'is-danger'
			                })
						}
            		})
			}
		},

		mounted () {
			this.fetch({
				userlesson: this.userLesson.id,
				user: this.user.id
			})
		}
	}
</script>