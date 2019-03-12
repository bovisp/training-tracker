<template>
  <section>
    <article 
      v-html="entry.body"
    ></article>

    <h3 class="is-3 has-text-weight-light title mt-4">
      Files
    </h3>

    <EntryFiles 
      :is-completed="true"
    />

    <h3 class="title is-3 has-text-weight-light mt-8">
      {{ trans('app.components.logbooks.comments') }}
    </h3>

    <Comments 
      v-if="Object.keys(entry).length > 0"
      :endpoint="commentsEndpoint"
      :create-roles="['supervisor', 'head_of_operations', 'apprentice']"
      :is-completed="false"
    />
  </section>
</template>

<script>
  import EntryFiles from '../userlessons/logbooks/EntryFiles'
  import Comments from '../comments/Comments'
  import { mapActions, mapGetters } from 'vuex'

  export default {
    props: {
      entryId: {
        required: true,
        type: Number
      },
      userId: {
        required: true,
        type: Number
      },
      userlessonId: {
        required: true,
        type: Number
      }
    },

    components: {
      EntryFiles,
      Comments
    },

    computed: {
      ...mapGetters({
        entry: 'userlessons/entry',
        userlesson: 'userlessons/userlesson'
      }),

      commentsEndpoint () {
        return `/users/${this.userId}/entries/${this.entryId}/comments`
      }
    },

    methods: {
      ...mapActions({
        fetch: 'notifications/fetchEntry'
      })
    },

    mounted () {
      this.fetch({
        entryId: this.entryId,
        userId: this.userId,
        userlessonId: this.userlessonId
      })
    }
  }
</script>