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
						Entry created at {{ entry.created_at }}
					</a>
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
			})
		}
	}
</script>