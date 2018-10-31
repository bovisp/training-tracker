<template>
	<div class="card mb-6">
		<header class="card-header">
			<div class="level is-full-width">
				<div class="level-left">
					<div class="level-item">
						<p class="card-header-title">
							<notification-type 
								:type="notification.data.data.noteType"
							/>
						</p>
					</div>
				</div>

				<div class="level-right">
					<time class="mr-2">{{ created }}</time>
				</div>
			</div>
		</header>

		<div class="card-content">
			<notification-content 
				:notification="notification"
			/>
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
	import NotificationType from './NotificationType'
	import NotificationContent from './NotificationContent'
	import dayjs from 'dayjs'
	import { mapActions } from 'vuex'

	export default {
		props: {
			notification: {
				type: Object,
				required: true
			}
		},

		components: {
			NotificationContent,
			NotificationType
		},

		computed: {
			created () {
				return dayjs(this.notification.data.created_at).format('MM/DD/YYYY')
			},

			isRead () {
				return this.notification.data.read_at !== null
			},
		},

		methods: {
			...mapActions({
				'deleteNotification': 'notifications/deleteNotification',
				'markAsRead': 'notifications/markAsRead'
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