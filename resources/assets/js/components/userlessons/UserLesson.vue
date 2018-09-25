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
					@click="patch"
				>
					Save lesson package
				</button>
			</div>
		</div>

		<user-lesson-status />

		<user-lesson-objectives />

		<!-- <user-lesson-notebooks v-if="!isLoading"></user-lesson-notebooks> -->

		<h3 class="title is-3 mt-16">
			Comments
		</h3>

		<!-- <comments :endpoint="commentEndpoint" /> -->

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
	import { mapGetters, mapActions } from 'vuex'

	export default {
		props: ['userLesson', 'user'],

		computed: {
			...mapGetters({
				isLoading: 'userlessons/isLoading'
			})
		},

		data () {
			return {
				formData: {},
				errors: {}
			}
		},

		components: {
			UserLessonStatus,
			UserLessonObjectives,
			// UserLessonNotebooks
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetch',
				patch: 'userlessons/patch'
			})
		},

		mounted () {
			this.fetch({
				userlesson: this.userLesson.id,
				user: this.user.id
			})

			window.events.$on('userlesson:save-success', message => this.$toast.open({
                message,
                position: 'is-top-right',
                type: 'is-success'
            }))
		}
	}
</script>