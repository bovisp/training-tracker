<template>
	<div>
		<b-modal 
			:active.sync="isActive" 
			:width="960" 
			scroll="keep" 
			:can-cancel="['escape', 'x']"
		>
			<div class="card">
				<div class="card-content">
					<EntryModal 
						:entry-id="entry.id"
					/>
				</div>
			</div>
		</b-modal>

		<a @click.prevent="isActive = true">
			Entry created at {{ entry.created_at }}
		</a>
	</div>
</template>

<script>
	import EntryModal from './EntryModal'

	export default {
		props: {
			entry: {
				type: Object,
				required: true
			}
		},

		components: {
			EntryModal
		},

		data () {
			return {
				isActive: false
			}
		}
	}
</script>