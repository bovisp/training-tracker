<template>
	<section>
		<article class="message is-info" v-if="!hasNotifications">
			<div class="message-body">
				{{ trans('app.components.notifications.nonotifications') }}
			</div>
		</article>

		<template v-else>
			<div class="flex items-center">
				<b-field label="Filter apprentices">
		            <b-select v-model="apprentice">
		            	<option value="">
		            		Select a name..
		            	</option>

		                <option
		                    v-for="option in apprenticeNames"
		                    :value="option"
		                    :key="option">
		                    {{ option }}
		                </option>
		            </b-select>
		        </b-field>

		        <button 
		        	class="button is-text"
		        	@click="apprentice = ''"
		        	style="margin-top: 1rem;"
		        >Clear</button>
			</div>

			<b-tabs 
				v-model="activeTab" 
				size="is-medium" 
			>
				<b-tab-item label="Unread">
					<div class="level">
						<div class="level-left">
							<div class="level-item">
								<button 
									class="button is-text has-text-info"
									@click="allRead"
								>{{ trans('app.components.notifications.markallread') }}</button>
							</div>

							<div class="level-item">
								<button 
									class="button is-text has-text-danger"
									@click="deleteUnread"
								>{{ trans('app.components.notifications.deleteallread') }}</button>
							</div>
						</div>

						<div class="level-right"></div>
					</div>

					<notification 
						v-for="notification in filtered.unread"
						:key="notification.id"
						:notification="notification"
					/>
				</b-tab-item>

				<b-tab-item label="Read">
					<div class="level">
						<div class="level-left">
							<div class="level-item">
								<button 
									class="button is-text has-text-info"
									@click="allUnread"
								>{{ trans('app.components.notifications.markallunread') }}</button>
							</div>

							<div class="level-item">
								<button 
									class="button is-text has-text-danger"
									@click="deleteRead"
								>{{ trans('app.components.notifications.deleteallread') }}</button>
							</div>
						</div>

						<div class="level-right"></div>
					</div>

					<notification 
						v-for="notification in filtered.read"
						:key="notification.id"
						:notification="notification"
					/>
				</b-tab-item>
			</b-tabs>
		</template>
		

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
				activeTab: 0,
				apprentice: ''
			}
		},

		computed: {
			...mapGetters({
				'isLoading': 'isLoading',
				'hasNotifications': 'notifications/hasNotifications',
				'read': 'notifications/read',
				'unread': 'notifications/unread',
				'apprenticeNames': 'notifications/apprenticeNames'
			}),

			filtered () {
				let notifications = {
					read: this.read,
					unread: this.unread
				}

				if (this.apprentice) {
					notifications.read = _.filter(notifications.read, notification => {
						let name = `${notification.meta.lessonPackageApprentice.firstname} ${notification.meta.lessonPackageApprentice.lastname}`
						return name === this.apprentice
					})

					notifications.unread = _.filter(notifications.unread, notification => {
						let name = `${notification.meta.lessonPackageApprentice.firstname} ${notification.meta.lessonPackageApprentice.lastname}`
						return name === this.apprentice
					})
				}

				return {
					read: notifications.read,
					unread: notifications.unread
				}
			}
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
		                message: this.trans('app.components.notifications.notificationsmarkedread'),
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			allUnread () {
				this.markAllAsUnread()
					.then(response => this.$toast.open({
		                message: this.trans('app.components.notifications.notificationsmarkedunread'),
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			deleteRead () {
				this.deleteAllRead()
					.then(response => this.$toast.open({
		                message: this.trans('app.components.notifications.notificationsdeleted'),
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			},

			deleteUnread () {
				this.deleteAllUnread()
					.then(response => this.$toast.open({
		                message: this.trans('app.components.notifications.unreadnotificationsdeleted'),
		                position: 'is-top-right',
		                type: 'is-success'
            		}))
			}
		},

		mounted () {
			this.fetch(this.user.id)

			window.events.$on('notifications:recalculate-tabs', () => {
				if (this.read.length === 0) {
					this.activeTab = 0
				}

				if (this.unread.length === 0) {
					this.activeTab = 1
				}
			})
		}
	}
</script>