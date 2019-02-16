<template>
	<div>
		<ul v-if="logbooks.length">
			<li
				v-for="(logbook, index) in sortedLogbooks"
				:key="logbook.id"
				:class="{ 'mb-1': index !== logbooks.length - 1 }"
			>
				<Entries 
					:logbook="logbook"
					:index="index"
				/>
			</li>
		</ul>

		<article class="message is-info" v-else>
			<div class="message-body">
				No logbooks required
			</div>
		</article>
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import Entries from './Entries'

	export default {
		props: {
			userlesson: {
				type: Object,
				required: true
			}
		},

		components: {
			Entries
		},

		computed: {
			...mapGetters({
				logbooks: 'userlessons/logbooks'
			}),

			sortedLogbooks () {
				return orderBy(this.logbooks, ['objective.number'], ['asc'])
			}
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetchLogbooks'
			})
		},

		mounted () {
			this.fetch(this.userlesson.id)
		}
	}
</script>