<template>
	<div>
		
	</div>
</template>

<script>
	export default {
		props: ["flash"],

		mounted () {
			console.log(this.flash)
			if (this.flash) {
				this.$buefy.toast.open({
                    message: this.flash.message,
                    position: this.flash.position ? this.flash.position : 'is-top-right',
                    type: this.flash.type ? this.flash.type : 'is-success'
				})
			}
		}
	}
</script>