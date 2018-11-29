<template>
	<div v-if="logbooks.length">
		<h3 class="title is-3 mt-16">
			{{ trans('app.components.userlessons.logbooks') }}
		</h3>

		<ul class="box">
			<li v-for="(logbook, index) in sortedLogbooks" :key="logbook.id">
				<p v-if="logbook.objective">
					<strong>{{ logbook.objective.number }}</strong> - {{ logbook.objective.name }}
				</p>

				<div class="mt-4"> 
					<p class="has-text-grey mt-2">
						{{ trans('app.components.userlessons.logbookentries') }} {{ logbook.entries.length }}
					</p>

					<p class="has-text-grey mt-2" v-if="logbook.lastEntryCreated">
						{{ trans('app.components.userlessons.entrycreatedmessage1') }} {{ creatorName(logbook) }} (<strong>{{ creatorRole(logbook) }}</strong>) {{ trans('app.components.userlessons.entrycreatedmessage2') }} {{ createdAt(logbook) }}
					</p>

					<p class="has-text-grey mt-2" v-if="logbook.lastEntryUpdateExists">
						{{ trans('app.components.userlessons.updatedentrymessage1') }} {{ editorName(logbook) }} (<strong>{{ editorRole(logbook) }}</strong>) {{ trans('app.components.userlessons.updatedentrymessage2') }} {{ editedAt(logbook) }}
					</p>

					<div class="level">
						<div class="level-left"></div>

						<div class="level-right">
							<div class="level-item">
								<a 
									class="button is-text has-text-info"
									:href="`${urlBase}/users/${user.id}/logbooks/${logbook.id}`"
								>
									<template v-if="!completedPackage">
										<i class="mdi mdi-square-edit-outline mr-2"></i>

										<span>{{ trans('app.components.userlessons.editlogbook') }}</span>
									</template>

									<span v-else>{{ trans('app.components.userlessons.viewlogbook') }}</span>
								</a>
							</div>
						</div>
					</div>
				</div>

				<hr v-if="index !== (logbooks.length - 1)">
			</li>
		</ul>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'
	import dayjs from 'dayjs'

	export default {
		data () {
			return {
				completedPackage: false
			}
		},

		computed: {
			...mapGetters({
				logbooks: 'userlessons/logbooks',
				user: 'userlessons/user'
			}),

			sortedLogbooks () {
				return orderBy(this.logbooks, ['objective.number'], ['asc'])
			}
		},

		methods: {
			editedAt (logbook) {
				return dayjs(logbook.lastEntryUpdate.edited_at).format('MM/DD/YYYY')
			},

			editorName(logbook) {
				console.log(logbook)
				return `${logbook.lastEntryUpdate.editor.firstname} ${logbook.lastEntryUpdate.editor.lastname}`
			},

			editorRole(logbook) {
				return logbook.lastEntryUpdate.editor.role
			},

			createdAt (logbook) {
				return dayjs(logbook.lastEntryCreated.created_at).format('MM/DD/YYYY')
			},

			creatorName(logbook) {
				return `${logbook.lastEntryCreated.creator.firstname} ${logbook.lastEntryCreated.creator.lastname}`
			},

			creatorRole(logbook) {
				return logbook.lastEntryCreated.creator.role
			}
		},

		mounted () {
			window.events.$on('completedPackage', () => {
				this.completedPackage = !this.completedPackage
			})
		}
	}
</script>