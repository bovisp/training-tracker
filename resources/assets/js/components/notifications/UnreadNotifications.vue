<template>
	<a 
		:href="`/users/${user.id}/notifications`" 
		:title="message"
	>
		<div class="icon">
			<i class="mdi" :class="hasNotifications"></i>
		</div>
	</a>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import pluralize from 'pluralize'

	export default {
		props: {
			user: {
				type: Object,
				required: true
			}
		},

		computed: {
			...mapGetters({
				'unread': 'notifications/unread'
			}),

			message () {
				if (!this.unread.length) {
					return this.trans('app.pages.layouts.notifications.nonotifications')
				}

				return `You have ${this.unread.length} unread ${pluralize('notification', this.unread.length)}`
			},

			hasNotifications () {
				return this.unread.length ? 'mdi-bell has-text-info' : 'mdi-bell-off has-text-black'
			}
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