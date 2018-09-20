<template>
	<form
		@submit.prevent="patch"
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
				<button class="button is-info is-small">Update</button>
			</div>

			<div class="control">
				<button 
					class="button is-text is-small"
					@click.prevent="cancel"
				>Cancel</button>
			</div>
		</div>
	</form>
</template>

<script>
	import Form from '../../classes/Form'

	export default {
		data () {
			return {
				form: new Form({
					body: this.comment.body
				})
			}
		},

		props: ['comment'],

		methods: {
			patch () {
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
			},

			cancel () {
				window.events.$emit('comment:edit-cancelled', this.comment)
			}
		}
	}
</script>