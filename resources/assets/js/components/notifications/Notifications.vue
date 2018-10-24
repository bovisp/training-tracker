<template>
	<section>
		<article class="message is-info" v-if="!hasNotifications">
			<div class="message-body">
				You have no notifications.
			</div>
		</article>

		<b-tabs v-model="activeTab" v-else>
			<b-tab-item label="Unread">
				<notification 
					v-for="notification in unread"
					:key="notification.id"
					:notification="notification"
					:user="user"
				/>
			</b-tab-item>

			<b-tab-item label="Read">
				<notification 
					v-for="notification in read"
					:key="notification.id"
					:notification="notification"
					:user="user"
				/>
			</b-tab-item>
		</b-tabs>
	</section>
</template>

<script>
	import Notification from './Notification'

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
				activeTab: 0,
				read: [],
				unread: []
			}
		},

		computed: {
			hasNotifications () {
				return this.read.length || this.unread.length
			}
		},

		mounted () {
			this.read = filter(this.user.notifications, notification => notification.read_at !== null)

			this.unread = filter(this.user.notifications, notification => notification.read_at === null)
		}
	}
</script>