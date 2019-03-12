<template>
  <div>
    <p>{{ notification.data.userName }} added a <a @click.prevent="$emit('view')">logbook entry</a> comment to {{ owner }} lesson package <a :href="`${urlBase}/users/${notification.data.userlessonUserId}/userlessons/${notification.data.userlessonId}`">"{{ notification.data.userlessonName }}"</a> under the objective "{{ notification.data.objectiveName }}"</p>
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
      owner () {
        if (this.authUser.role === 'apprentice') {
          return 'your'
        }
        
        return this.notification.data.userId === this.notification.data.userlessonUserId ? 'their' : `${this.notification.data.userlessonUserName}'s`
      }
    }
  }
</script>