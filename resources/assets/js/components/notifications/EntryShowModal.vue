<template>
  <div>
    <b-modal 
      :active="entryModalActive === true" 
      :onCancel="closeModal"
      :width="960" 
      scroll="keep" 
      :can-cancel="['escape', 'x']"
    >
      <div class="card">
        <div class="card-content">
          <EntryShow
            :entryId="entryId"
            :userId="userId"
            :userlessonId="userlessonId"
          />
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import EntryShow from './EntryShow'

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
      EntryShow
    },

    data () {
      return {
        entryModalActive: false
      }
    },

    methods: {
      ...mapActions({
        close: 'notifications/close'
      }),

      closeModal () {
        this.entryModalActive = false

        this.close()
      }
    },

    mounted () {
      window.events.$on('showmodal', notification => {
        if (notification.data.logbookEntryId === this.entryId) {
          this.entryModalActive = true
        }
      })
    }
  }
</script>