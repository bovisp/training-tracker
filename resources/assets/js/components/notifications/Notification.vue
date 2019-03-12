<template>
  <div class="card mb-4">
    <header class="card-header is-flex items-center">
      <p class="card-header-title">
        {{ notificationTypes[notification.data.noteType] }}
      </p>

      <p class="ml-auto mr-2">
        {{ createdDate() }}
      </p>
    </header>

    <div class="card-content">
      <div class="content">
        <LogbookEntryAdded 
          v-if="notification.data.noteType === 'logbook_entry_added'"
          :notification="notification"
          @view="show"
        />

        <LogbookEntryUpdated 
          v-if="notification.data.noteType === 'logbook_entry_updated'"
          :notification="notification"
          @view="show"
        />

        <LogbookEntryCommentAdded 
          v-if="notification.data.noteType === 'logbook_entry_comment_added'"
          :notification="notification"
          @view="show"
        />

        <LogbookEntryCommentUpdated 
          v-if="notification.data.noteType === 'logbook_entry_comment_updated'"
          :notification="notification"
          @view="show"
        />
      </div>
    </div>

    <footer class="card-footer">
      <div class="card-footer-item">
        <a 
          href="#" 
          class="has-text-danger"
          @click.prevent="destroy"
        >{{ trans('app.general.buttons.delete') }}</a>
      </div>

      <template v-if="!isRead">
        <div class="card-footer-item" >
          <a
            href="#"
            @click.prevent="read"
          >{{ trans('app.components.notifications.markasread') }}</a>
        </div>
      </template>
      
      <template v-else>
        <div class="card-footer-item" >
          <a
            href="#"
            @click.prevent="unread"
          >{{ trans('app.components.notifications.markasunread') }}</a>
        </div>
      </template>
    </footer>

    <EntryShowModal 
      :entryId="notification.data.logbookEntryId"
      :userId="notification.data.userlessonUserId"
      :userlessonId="notification.data.userlessonId"
    />
  </div>
</template>

<script>
  import LogbookEntryAdded from './types/LogbookEntryAdded'
  import LogbookEntryUpdated from './types/LogbookEntryUpdated'
  import LogbookEntryCommentAdded from './types/LogbookEntryCommentAdded'
  import LogbookEntryCommentUpdated from './types/LogbookEntryCommentUpdated'
  import EntryShowModal from './EntryShowModal'
  import dayjs from 'dayjs'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      notification: {
        type: Object,
        required: true
      }
    },

    components: {
      LogbookEntryAdded,
      LogbookEntryUpdated,
      LogbookEntryCommentAdded,
      LogbookEntryCommentUpdated,
      EntryShowModal
    },

    computed: {
      ...mapGetters({
        notificationTypes: 'notifications/notificationTypes'
      }),

      isRead () {
        return this.notification.read_at !== null
      }
    },

    methods: {
      ...mapActions({
        deleteNotification: 'notifications/deleteNotification',
        markAsRead: 'notifications/markAsRead',
        markAsUnread: 'notifications/markAsUnread'
      }),

      createdDate () {
        return `${dayjs(this.notification.created_at).format('MM/DD/YYYY hh:mmA')}`
      },

      show (e) {
        window.events.$emit('showmodal', this.notification)
      },

      async destroy () {
        let response = await this.deleteNotification(this.notification.id)

        this.$toast.open({
          message: this.trans('app.components.notifications.notificationdeleted'),
          position: 'is-top-right',
          type: 'is-success'
        })
      },

      async read () {
        let response = await this.markAsRead(this.notification.id)

        this.$toast.open({
          message: this.trans('app.components.notifications.notificationread'),
          position: 'is-top-right',
          type: 'is-success'
        })
      },

      async unread () {
        let response = await this.markAsUnread(this.notification.id)

        this.$toast.open({
          message: this.trans('app.components.notifications.notificationunread'),
          position: 'is-top-right',
          type: 'is-success'
        })
      }
    }
  }
</script>