<template>
	<div class="mt-8">
		<h3 class="title is-3 mb-8">{{ trans('app.components.logbooks.entries') }}</h3>

		<template v-if="!entries.length">
			<article class="message is-info">
				<div class="message-body">
					{{ trans('app.components.logbooks.noentries') }}
				</div>
			</article>
		</template>

		<template v-else>
			<div class="content">
				<ul>
					<logbook-entry-item 
						v-for="entry in entries" 
						:key="entry.id" 
						:entry="entry"
					/>
				</ul>
			</div>
		</template>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'
	import LogbookEntryItem from './LogbookEntryItem'

	export default {
		components: {
			LogbookEntryItem
		},

		computed: {
			...mapGetters({
				entries: 'logbooks/entries'
			})
		}
	}
</script>