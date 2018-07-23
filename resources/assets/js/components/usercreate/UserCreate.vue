<template>
	<div>
		<div class="is-flex">
	        <button 
	            class="button is-link ml-auto" 
	            @click="store" 
	        >
	            Add users
	        </button>
        </div>

		<data-table :endpoint="endpoint" :has-checkbox="true" />
	</div>
</template>

<script>
	export default {
		props: ['endpoint', 'postEndpoint', 'redirectEndpoint'],

		methods: {
			store () {
				console.log("store")
			}
		},

		mounted () {
			window.events.$on('user:checkbox', record => {
				console.log("Hi")
			})
		}
	}
</script>