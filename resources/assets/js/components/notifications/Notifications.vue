<template>
	<section>
		<article class="message is-info" v-if="!hasNotifications">
			<div class="message-body">
				You have no notifications.
			</div>
		</article>

		<b-tabs 
			v-model="activeTab" 
			size="is-medium" 
			v-else
		>
			<b-tab-item label="Unread" v-if="unread.length">
				<div class="level">
					<div class="level-left">
						<div class="level-item">
							<button 
								class="button is-text has-text-info"
								@click="allRead"
							>Mark all as read</button>
						</div>

						<div class="level-item">
							<button 
								class="button is-text has-text-danger"
								@click="deleteUnread"
							>Delete all unread</button>
						</div>
					</div>

					<div class="level-right"></div>
				</div>

				<notification 
					v-for="notification in unread"
					:key="notification.id"
					:notification="notification"
				/>
			</b-tab-item>

			<b-tab-item label="Read" v-if="read.length">
				<div class="level">
					<div class="level-left">
						<div class="level-item">
							<button 
								class="button is-text has-text-info"
								@click="allUnread"
							>Mark all as unread</button>
						</div>

						<div class="level-item">
							<button 
								class="button is-text has-text-danger"
								@click="deleteRead"
							>Delete all read</button>
						</div>
					</div>

					<div class="level-right"></div>
				</div>

				<notification 
					v-for="notification in read"
					:key="notification.id"
					:notification="notification"
				/>
			</b-tab-item>
		</b-tabs>

		<b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
	</section>
</template>

<script>
	import Notification from './Notification'
	import { mapActions, mapGetters } from 'vuex'

	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		},

		components: {
			Notification
		},

		data () {
			return {
				activeTab: 0
			}
		},

		computed: {
			...mapGetters({
				'isLoading': 'isLoading',
				'hasNotifications': 'notifications/hasNotifications',
				'read': 'notifications/read',
				'unread': 'notifications/unread'
			})
		},

		methods: {
			...mapActions({
				'fetch': 'notifications/fetch',
				'markAllAsRead': 'notifications/markAllAsRead',
				'markAllAsUnread': 'notifications/markAllAsUnread',
				'deleteAllRead': 'notifications/deleteAllRead',
				'deleteAllUnread': 'notifications/deleteAllUnread'
			}),

			allRead () {
				this.markAllAsRead()
					.then(response => this.$toast.open({
		                message: 'Notifications marked as read.',
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			allUnread () {
				this.markAllAsUnread()
					.then(response => this.$toast.open({
		                message: 'Notifications marked as unread.',
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			deleteRead () {
				this.deleteAllRead()
					.then(response => this.$toast.open({
		                message: 'Read notifications deleted.',
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			deleteUnread () {
				this.deleteAllUnread()
					.then(response => this.$toast.open({
		                message: 'Unread notifications deleted.',
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			}
		},

		mounted () {
			this.fetch(this.user.id)
		}
	}
</script>