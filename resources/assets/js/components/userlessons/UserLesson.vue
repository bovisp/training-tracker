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
			style="position: fixed; bottom: 0; left: 0; background: #FFF; display: flex; width: 100%; z-index: 10;"
			class="p-4 has-background-white-ter" 
			v-if="hasRoleOf(['supervisor', 'head_of_operations', 'manager'])"
		>
				<button 
					class="button is-info ml-auto"
					:class="{ 'is-loading' : isLoading }"
					@click="submit"
				>
					<i class="mdi mdi-content-save mr-2"></i>
					Save lesson package
				</button>
		</div>

		<user-lesson-status />

		<user-lesson-objectives />

		<user-lesson-notebooks></user-lesson-notebooks>

		<h3 class="title is-3 mt-16">
			Comments
		</h3>

		<comments 
			:endpoint="commentsEndpoint"
			:is-completed="isCompleted"
			:create-roles="['supervisor', 'head_of_operations']"
		/>

		<h3 class="title is-3 mt-16">
			Final evaluation
		</h3>

		<user-lesson-final></user-lesson-final>

		<b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
	</div>
</template>

<script>
	import UserLessonStatus from './UserLessonStatus'
	import UserLessonObjectives from './UserLessonObjectives'
	import UserLessonFinal from './UserLessonFinal'
	import UserLessonNotebooks from './UserLessonNotebooks'
	import Comments from '../comments/Comments'
	import { mapGetters, mapActions } from 'vuex'

	export default {
		props: ['userLesson', 'user'],

		computed: {
			...mapGetters({
				isLoading: 'isLoading',
				errors: 'errors',
				isCompleted: 'userlessons/isCompleted'
			}),

			commentsEndpoint () {
				return `/users/${this.user.id}/userlessons/${this.userLesson.id}/comments`
			}
		},

		components: {
			UserLessonStatus,
			UserLessonObjectives,
			UserLessonFinal,
			UserLessonNotebooks,
			Comments
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetch',
				patch: 'userlessons/patch',
				updateCompletedPackage: 'userlessons/updateCompletedPackage'
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
			                    message: this.errors.denied,
			                    type: 'is-danger'
			                })
						}

						if (error.response.status === 422 && this.errors.completed) {
							this.$dialog.alert({
			                    title: 'Incomplete',
			                    message: this.errors.completed[0],
			                    type: 'is-danger'
			                })

			                this.updateCompletedPackage()
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