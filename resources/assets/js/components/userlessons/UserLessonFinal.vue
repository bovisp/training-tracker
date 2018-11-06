<template>
	<section>
		<div class="field">
            <label class="checkbox">
				<input 
					type="checkbox"
					:value="completedPackage"
					:checked="completedPackage"
					@change="update"
					v-if="hasRoleOf(['administrator', 'manager', 'head_of_operations'])"
				> 

				<template v-else>
					<span
						v-if="completedPackage"
						v-html="`&check;`"
						style="color: green;"
						class="mr-4"
					>
						<i class=""></i>mdi-window-minimize
					</span>

					<span
						v-else
						v-html="`&ndash;`"
						class="has-text-grey has-text-weight-bold mr-4"
					></span>
				</template>
				
				This lesson package has been successfully completed
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