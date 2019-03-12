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
									@click.prevent="allRead"
								>{{ trans('app.components.notifications.markallread') }}</button>
							</div>

							<div class="level-item">
								<button 
									class="button is-text has-text-danger"
									@click.prevent="deleteUnread"
								>{{ trans('app.components.notifications.deleteallunread') }}</button>
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
					<div class="level-left mb-4">
							<div class="level-item">
								<button 
									class="button is-text has-text-info"
									@click.prevent="allUnread"
								>{{ trans('app.components.notifications.markallunread') }}</button>
							</div>

							<div class="level-item">
								<button 
									class="button is-text has-text-danger"
									@click.prevent="deleteRead"
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
	</section>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Notification from './Notification'

	export default {
		props: {
			userInit: {
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
				user: 'notifications/user',
				read: 'notifications/read',
				unread: 'notifications/unread',
				apprenticeNames: 'notifications/apprenticeNames'
			}),

			hasNotifications () {
				return this.unread.length || this.read.length
			},

			filtered () {
				let notifications = {
					read: this.read,
					unread: this.unread
				}

				if (this.apprentice) {
					notifications.read = _.filter(notifications.read, notification => {
						let name = notification.data.userlessonUserName
						return name === this.apprentice
					})

					notifications.unread = _.filter(notifications.unread, notification => {
						let name = notification.data.userlessonUserName
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
				fetch: 'notifications/fetch',
				markAllAsRead: 'notifications/markAllAsRead',
				markAllAsUnread: 'notifications/markAllAsUnread',
				deleteAllRead: 'notifications/deleteAllRead',
				deleteAllUnread: 'notifications/deleteAllUnread'
			}),

			async allRead () {
				let response = await this.markAllAsRead()

				this.$toast.open({
          message: this.trans('app.components.notifications.notificationsmarkedread'),
          position: 'is-top-right',
          type: 'is-success'
    		})
			},

			async allUnread () {
				let response = await this.markAllAsUnread()

				this.$toast.open({
          message: this.trans('app.components.notifications.notificationsmarkedunread'),
          position: 'is-top-right',
          type: 'is-success'
    		})
			},

			async deleteRead () {
				let response = await this.deleteAllRead()

				this.$toast.open({
          message: this.trans('app.components.notifications.notificationsdeleted'),
          position: 'is-top-right',
          type: 'is-success'
    		})
			},

			async deleteUnread () {
				let response = await this.deleteAllUnread()

				this.$toast.open({
          message: this.trans('app.components.notifications.unreadnotificationsdeleted'),
          position: 'is-top-right',
          type: 'is-success'
    		})
			}
		},

		async mounted () {
			await this.fetch(this.userInit.id)
		}
	}
</script>