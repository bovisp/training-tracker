<template>
	<div>
		<hr>

		<template v-if="!editing">
			<div class="level">
				<div class="level-left">
					<div class="level-item">
						<button 
							class="button is-info"
							@click.prevent="editing = true"
						>Edit entry</button>
					</div>

					<div class="level-item">
						<button 
							class="button is-text has-text-danger"
							@click.prevent="remove"
						>Delete entry</button>
					</div>
				</div>

				<div class="level-right">
					<div class="level-item">
						<a 
							href="#"
							@click.prevent="hide"
						>Return to entries</a>
					</div>
				</div>
			</div>
			
			<div class="content">
				<p>
					<strong>Logbook entry created: </strong>{{ entry.created_at }}
					by {{ entry.created_by.firstname }} {{ entry.created_by.lastname }}
					(<strong>{{ entry.created_by.role }}</strong>)
				</p>

				<p v-if="entry.edited_at">
					<strong>Logbook entry edited: </strong>
					{{ entry.edited_at }} by 
					{{ entry.edited_by.firstname }} {{ entry.edited_by.lastname }} 
					(<strong>{{ entry.edited_by.role }}</strong>)
				</p>

				<article v-html="entry.body"></article>
			</div>
		</template>

		<template v-else>
			<logbook-entry-edit 
				:data="entry.body"
			/>
		</template>

		<h3 class="title is-3">Comments</h3>

		<comments 
			:endpoint="commentsEndpoint"
			:create-roles="['supervisor', 'head_of_operations', 'apprentice']"
		/>
		
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'
	import LogbookEntryEdit from './LogbookEntryEdit'
	import Comments from '../comments/Comments'

	export default {
		components: {
			LogbookEntryEdit,
			Comments
		},

		data () {
			return {
				editing: false
			}
		},

		computed: {
			...mapGetters({
				entry: 'logbooks/entry',
				userId: 'logbooks/userId',
				entryId: 'logbooks/entryId'
			}),

			commentsEndpoint () {
				return `/users/${this.userId}/entries/${this.entryId}/comments`
			}
		},

		methods: {
			...mapActions({
				hide: 'logbooks/hide',
				destroy: 'logbooks/destroy'
			}),

			remove () {
				this.$dialog.confirm({
                    title: 'Delete entry',
                    message: 'Are you sure you want to <b>delete</b> this logbook entry?',
                    confirmText: 'Delete entry',
                    type: 'is-danger',
                    onConfirm: () => this.destroy()
                    	.then(response => {
                    		this.$toast.open({
				                message: response.data.flash,
				                position: 'is-top-right',
				                type: 'is-success'
	            			})
                    	}).catch(error => {})
                })
			}
		},

		mounted () {
			window.events.$on('logbook-entry:cancel', () => this.editing = false)
		}
	}
</script>