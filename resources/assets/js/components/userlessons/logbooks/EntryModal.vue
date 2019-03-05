<template>
	<div>
		<b-modal 
			:active="entryModalActive === true" 
			:onCancel="close"
			:width="960" 
			scroll="keep" 
			:can-cancel="['escape', 'x']"
		>
			<div class="card">
				<div class="card-content">
					<Entry />
				</div>
			</div>
		</b-modal>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'
	import Entry from './Entry'

	export default {
		components: {
			Entry
		},

		computed: {
			...mapGetters({
				entryModalActive: 'userlessons/entryModalActive'
			})
		},

		methods: {
			...mapActions({
				close: 'userlessons/close'
			})
		}
	}
</script>