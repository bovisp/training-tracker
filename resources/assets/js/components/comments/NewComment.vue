<template>
	<div class="mb-6">
		<button 
			class="button is-info"
			@click.prevent="active = true"
			v-if="!active"
		>
			New comment
		</button>

		<template v-else>
			<form
				@submit.prevent="store"
				@keydown="form.errors.clear($event.target.name)"
			>
				<div class="field">
					<label class="label" for="body">Comment</label>

					<div class="control">
						<textarea 
							class="textarea"
							id="body" 
							v-model="form.body"
							:class="{ 'is-danger' : form.errors.has('body') }"
						></textarea>
					</div>

					<p
						class="help is-danger"
						v-if="form.errors.has('body')"
						v-text="form.errors.get('body')"
					></p>
				</div>

				<div class="field is-grouped">
					<div class="control">
						<button class="button is-info">Submit</button>
					</div>

					<div class="control">
						<button 
							class="button is-text"
							@click.prevent="active = false"
						>Cancel</button>
					</div>
				</div>
			</form>
		</template>
	</div>
</template>

<script>
	import Form from '../../classes/Form'

	export default {
		props: ['endpoint'],

		data () {
			return {
				active: false,
				form: new Form({
					'body': ''
				})
			}
		},

		methods: {
			store () {
				this.form.post(this.endpoint, this.form)
		        	.then(({data}) => {
		        		this.active = false

		        		window.events.$emit('comment:stored', data)

		        		this.$toast.open({
	                        message: 'Comment created.',
	                        position: 'is-top-right',
	                        type: 'is-success'
	                    })
		        	});
			}			
		}
	}
</script>