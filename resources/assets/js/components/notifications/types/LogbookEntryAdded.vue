<template>
  <div>
    <p>{{ notification.data.creatorName }} added a <a @click.prevent="$emit('view')">logbook entry</a> to {{ isOwner }} lesson package <a :href="`${urlBase}/users/${notification.data.userlessonUserId}/userlessons/${notification.data.userlessonId}`">"{{ notification.data.userlessonName }}"</a> under the objective "{{ notification.data.objectiveName }}"</p>
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
      isOwner () {
        return this.notification.data.creatorId === this.notification.data.userlessonUserId ? 'their' : `${this.notification.data.creatorName}'s`
      }
    }
  }
</script>