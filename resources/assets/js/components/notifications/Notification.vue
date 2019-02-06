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
				>{{ trans('app.general.buttons.delete') }}</a>
			</div>

			<template v-if="!isRead">
				<div class="card-footer-item" >
					<a
						href="#"
						@click="read"
					>{{ trans('app.components.notifications.markasread') }}</a>
				</div>
			</template>
			
			<template v-else>
				<div class="card-footer-item" >
					<a
						href="#"
						@click="unread"
					>{{ trans('app.components.notifications.markasunread') }}</a>
				</div>
			</template>
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
				'markAsRead': 'notifications/markAsRead',
				'markAsUnread': 'notifications/markAsUnread'
			}),

			destroy () {
				this.deleteNotification(this.notification.data.id)
					.then(response => this.$toast.open({
		                message: this.trans('app.components.notifications.notificationdeleted'),
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			read () {
				this.markAsRead(this.notification.data.id)
					.then(response => this.$toast.open({
		                message: this.trans('app.components.notifications.notificationread'),
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			unread () {
				this.markAsUnread(this.notification.data.id)
					.then(response => {
						this.$toast.open({
			                message: this.trans('app.components.notifications.notificationunread'),
			                position: 'is-top-right',
			                type: 'is-success'
	            		})
					})
			}
		}
	}
</script>