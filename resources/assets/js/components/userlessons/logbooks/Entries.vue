<template>
	<section>
		<h3 
			class="title is-5"
			:class="{ 'mt-4': index !== 0 }"
		>
			{{ logbook.objective.number }} - 
			<span class="has-text-weight-light">{{ logbook.objective.name }}</span>
		</h3>

		<ul class="ml-4">
			<template v-if="logbook.entries.length">
				<li v-for="entry in logbook.entries">
					<a @click.prevent="open({entryId: entry.id, logbookId: null})">
						Entry
					</a>

					<span class="is-block ml-4">
						<small>Created at {{ formatDate(entry.created_at) }} by {{ getUser(entry, 'creator') }}</small>
					</span>

					<span class="is-block ml-4" v-if="entry.editor !== null">
						<small>Edited at {{ formatDate(entry.updated_at) }} by {{ getUser(entry, 'editor') }}</small>
					</span>

					<span class="is-block ml-4" v-if="entry.comments.length > 0">
						<small>Latest comment by {{ creatorDate(entry) }} by {{ creatorName(entry) }}</small>
					</span>
				</li>
			</template>

			<template v-else>
				<li>
					<span class="has-text-info">No entries added</span>
				</li>
			</template>
		</ul>
	</section>
</template>

<script>
	import { mapActions } from 'vuex'
	import dayjs from 'dayjs'

	export default {
		props: {
			logbook: {
				type: Object,
				required: true
			},
			index: {
				type: Number,
				required: true
			}
		},

		methods: {
			...mapActions({
				open: 'userlessons/open'
			}),

			formatDate(date) {
				return dayjs(date).format('MM/DD/YYYY hh:mmA')
			},

			getUser(entry, type) {
				return `${entry[type].firstname} ${entry[type].lastname} (${entry[type].roles[0].name})`
			},

			creatorName (entry) {
				if (entry.comments.length > 0) {
					let comment = (_.orderBy(entry.comments, ['created_at'], ['asc']))[entry.comments.length - 1]

					return `${comment.user.firstname} ${comment.user.lastname} (${comment.user.roles[0].name})`
				}
			},

			creatorDate (entry) {
				if (entry.comments.length > 0) {
					let comment = (_.orderBy(entry.comments, ['created_at'], ['asc']))[entry.comments.length - 1]

					return `${dayjs(comment.created_at).format('MM/DD/YYYY hh:mmA')}`
				}
			}
		}
	}
</script>