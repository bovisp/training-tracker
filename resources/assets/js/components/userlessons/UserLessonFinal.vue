<template>
	<section>
		<div class="field">
            <label class="checkbox">
				<input 
					type="checkbox"
					:value="completedPackage"
					:checked="completedPackage"
					@change="update"
				> This lesson package has been successfully completed
			</label>
        </div>
	</section>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {
		computed: {
			...mapGetters({
				completedPackage: 'userlessons/completedPackage'
			}),
		},

		methods: {
			...mapActions({
				update: 'userlessons/updateCompletedPackage'
			})
		}
	}
</script>