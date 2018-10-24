<template>
	<div class="card mb-6">
		<header class="card-header">
			<p class="card-header-title">New logbook entry</p>
		</header>

		<div class="card-content">
			<div class="content">
				<span>
					 created an entry</a> for the
				</span>
				objective "" lesson package.
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			notification: {
				type: Object,
				required: true
			},
			user: {
				type: Object,
				required: true
			}
		},

		data () {
			return {
				meta: {}
			}
		},

		mounted () {
			
		}
	}
</script>