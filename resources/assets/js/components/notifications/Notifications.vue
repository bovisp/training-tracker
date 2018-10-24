<template>
	<section>
		<article class="message is-info" v-if="!hasNotifications">
			<div class="message-body">
				You have no notifications.
			</div>
		</article>

		<b-tabs v-model="activeTab" v-else>
			<b-tab-item label="Unread" v-if="unread.length">
				<notification 
					v-for="notification in unread"
					:key="notification.id"
					:notification="notification"
				/>
			</b-tab-item>

			<b-tab-item label="Read" v-if="read.length">
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
				'fetch': 'notifications/fetch'
			})
		},

		mounted () {
			this.fetch(this.user.id)
		}
	}
</script>