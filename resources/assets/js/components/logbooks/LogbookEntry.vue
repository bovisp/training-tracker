<template>
	<div>
		<hr>

		<template v-if="!editing">
			<div class="level">
				<div class="level-left">
					<div class="level-item">
						<button 
							class="button is-text has-text-info"
							@click.prevent="editing = true"
							v-if="!completedPackage"
						>{{ trans('app.components.logbooks.editentry') }}</button>
					</div>

					<div class="level-item">
						<button 
							class="button is-text has-text-danger"
							@click.prevent="remove"
							v-if="!completedPackage"
						>{{ trans('app.components.logbooks.deleteentry') }}</button>
					</div>
				</div>

				<div class="level-right">
					<div class="level-item">
						<a 
							href="#"
							@click.prevent="hide"
						>{{ trans('app.components.logbooks.returntoentries') }}</a>
					</div>
				</div>
			</div>
			
			<div class="content mt-8">
				<p>
					<strong>{{ trans('app.components.logbooks.entrycreated') }} </strong>{{ entry.created_at }}
					{{ trans('app.components.logbooks.by') }} {{ entry.created_by.firstname }} {{ entry.created_by.lastname }}
					(<strong>{{ entry.created_by.role }}</strong>)
				</p>

				<p v-if="entry.edited_at">
					<strong>{{ trans('app.components.logbooks.entryedited') }} </strong>
					{{ entry.edited_at }} {{ trans('app.components.logbooks.by') }} 
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

		<logbook-entry-files />

		<h3 class="title is-3 mt-8">{{ trans('app.components.logbooks.comments') }}</h3>

		<comments 
			:endpoint="commentsEndpoint"
			:create-roles="['supervisor', 'head_of_operations', 'apprentice']"
			:is-completed="completedPackage === 1 ? true : false"
		/>
		
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'
	import LogbookEntryEdit from './LogbookEntryEdit'
	import Comments from '../comments/Comments'
	import LogbookEntryFiles from './LogbookEntryFiles'

	export default {
		components: {
			LogbookEntryEdit,
			Comments,
			LogbookEntryFiles
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
				entryId: 'logbooks/entryId',
				completedPackage: 'logbooks/completedPackage'
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
                    title: this.trans('app.components.logbooks.deleteentry'),
                    message: this.trans('app.components.logbooks.deleteentryconfirm'),
                    confirmText: this.trans('app.components.logbooks.deleteentry'),
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