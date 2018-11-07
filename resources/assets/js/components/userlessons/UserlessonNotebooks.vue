<template>
	<div>
		<h3 class="title is-3 mt-16">
			Logbooks
		</h3>

		<ul class="box">
			<li v-for="(logbook, index) in logbooks" :key="logbook.id">
				<p>
					<strong>{{ logbook.objective.number }}</strong> - {{ logbook.objective.name }}
				</p>

				<div class="mt-4"> 
					<p class="has-text-grey mt-2">
						Entries: {{ logbook.entries.length }}
					</p>

					<p class="has-text-grey mt-2" v-if="logbook.lastEntryCreated">
						Latest entry created by: {{ creatorName(logbook) }} (<strong>{{ creatorRole(logbook) }}</strong>) on {{ createdAt(logbook) }}
					</p>

					<p class="has-text-grey mt-2" v-if="logbook.lastEntryUpdateExists">
						Last updated by: {{ editorName(logbook) }} (<strong>{{ editorRole(logbook) }}</strong>) on {{ editedAt(logbook) }}
					</p>

					<div class="level">
						<div class="level-left"></div>

						<div class="level-right">
							<div class="level-item">
								<a 
									class="button is-text has-text-info"
									:href="`${urlBase}/users/${user.id}/logbooks/${logbook.id}`"
								>
									<i class="mdi mdi-square-edit-outline mr-2"></i>

									Edit logbook
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
		computed: {
			...mapGetters({
				logbooks: 'userlessons/logbooks',
				user: 'userlessons/user'
			})
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
		}
	}
</script>