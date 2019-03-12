<template>
  <div>
    <p>
      {{ notification.data.editorName }} updated {{ owner }} <a @click.prevent="$emit('view')">logbook entry</a> within {{ userlessonOwner }} lesson package <a :href="`${urlBase}/users/${notification.data.userlessonUserId}/userlessons/${notification.data.userlessonId}`">"{{ notification.data.userlessonName }}"</a> under the objective "{{ notification.data.objectiveName }}"
    </p>
  </div>
</template>

<script>
  export default {
    props: {
      notification: {
        required: true,
        type: Object
      }
    },
    computed: {
      userlessonOwner () {
        return this.notification.data.editorId === this.notification.data.userlessonUserId ? 'their' : `${this.notification.data.userlessonUserName}'s`
      },

      owner () {
        return this.notification.data.creatorId === this.notification.data.editorId ? 'their' : `${this.notification.data.creatorName}'s`
      }
    }
  }
</script>