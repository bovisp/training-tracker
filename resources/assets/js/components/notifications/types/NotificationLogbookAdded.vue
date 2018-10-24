<template>
	<div class="card mb-6">
		<header class="card-header">
			<div class="level is-full-width">
				<div class="level-left">
					<div class="level-item">
						<p class="card-header-title">New logbook entry</p>
					</div>
				</div>

				<div class="level-right">
					<time class="mr-2">{{ created }}</time>
				</div>
			</div>
		</header>

		<div class="card-content">
			<div class="content">
				<span v-if="creator.id !== apprentice.id">
					{{ creatorName }} created an entry in {{ apprenticeName }}'s <a :href="logbookUrl">logbook</a> for the 
				</span>

				<span v-else>
					{{ apprenticeName }} created an entry in their <a :href="logbookUrl">logbook</a> for the 
				</span>

				objective "{{ objective }}" in lesson package <a :href="lessonPackageUrl">"{{ package }}"</a>.
			</div>
		</div>

		<footer class="card-footer">
			<div class="card-footer-item">
				<a 
					href="#" 
					class="has-text-danger"
					@click="destroy"
				>Delete</a>
			</div>

			<div class="card-footer-item" v-if="!isRead">
				<a
					href="#"
					@click="read"
				>Mark as read</a>
			</div>
		</footer>
	</div>
</template>

<script>
	import dayjs from 'dayjs'
	import { mapActions, mapGetters } from 'vuex'

	export default {
		props: {
			notification: {
				type: Object,
				required: true
			}
		},

		computed: {
			...mapGetters({
				'user': 'notifications/user'
			}),

			isRead () {
				return this.notification.data.read_at !== null
			},

			creator () {
				return this.notification.meta.logbookEntryCreator
			},

			creatorName () {
				return `${this.notification.meta.logbookEntryCreator.firstname} ${this.notification.meta.logbookEntryCreator.lastname}`
			},

			apprentice () {
				return this.notification.meta.lessonPackageApprentice
			},

			apprenticeName () {
				return `${this.notification.meta.lessonPackageApprentice.firstname} ${this.notification.meta.lessonPackageApprentice.lastname}`
			},

			objective () {
				return this.notification.meta.objective
			},

			package () {
				return this.notification.meta.lessonPackage.package
			},

			logbookUrl () {
				return `/users/${this.apprentice.id}/logbooks/${this.notification.meta.logbookId}`
			},

			lessonPackageUrl () {
				return `/users/${this.apprentice.id}/userlessons/${this.notification.meta.lessonPackage.id}`
			},

			created () {
				return dayjs(this.notification.data.created_at).format('MM/DD/YYYY')
			}
		},

		methods: {
			...mapActions({
				'deleteNotification': 'notifications/deleteNotification',
				'markAsRead': 'notifications/markAsRead',
				'fetch': 'notifications/fetch'
			}),

			destroy () {
				this.deleteNotification(this.notification.data.id)
					.then(response => this.$toast.open({
		                message: 'Notification successfully deleted.',
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			read () {
				this.markAsRead(this.notification.data.id)
					.then(response => this.$toast.open({
		                message: 'Notification marked as read.',
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			}
		}
	}
</script>