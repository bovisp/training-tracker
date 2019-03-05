<template>
	<div>
		<ul>
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
	</div>
</template>

<script>
	import { mapGetters } from 'vuex'
	import Entries from './Entries'

	export default {
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
		}
	}
</script>