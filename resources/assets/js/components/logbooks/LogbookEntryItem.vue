<template>
	<li>
		<a 
			href="#" class="is-size-5"
			@click.prevent="show(entry.id)"
		>
			Entry created at: {{ entry.created_at }}
		</a>

		<small class="has-text-grey" v-if="entry.edited_at">
			Edited at: {{ entry.edited_at }} by 
			{{ entry.edited_by.firstname }} {{ entry.edited_by.lastname }} 
			(<strong>{{ entry.edited_by.role }}</strong>)
		</small>
	</li>
</template>

<script>
	import { mapActions } from 'vuex'

	export default {
		props: {
			entry: {
				type: Object,
				required: true
			}
		},

		methods: {
			...mapActions({
				show: 'logbooks/show'
			})
		}
	}
</script>