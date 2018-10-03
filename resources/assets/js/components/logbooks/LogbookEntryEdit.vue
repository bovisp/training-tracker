<template>
	<div>
		<vue-editor 
			v-model="form.body"
			:editorOptions="editorSettings"
		></vue-editor>

		<p 
			v-if="errors.body"
			v-text="errors.body[0]"
			class="has-text-danger"
			style="margin-top: 80px; margin-bottom: -50px;" 
		></p>

		<div class="level mb-8" style="margin-top: 80px;">
			<div class="level-left">
				<div class="level-item">
					<button
						@click.prevent="submit"
						class="button is-info"
					>Update</button>
				</div>

				<div class="level-item">
					<button
						@click.prevent="cancel"
						class="button is-text"
					>Cancel</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { VueEditor, Quill } from 'vue2-editor'
	import { ImageDrop } from 'quill-image-drop-module'
	import { mapActions, mapGetters } from 'vuex'

	Quill.register('modules/imageDrop', ImageDrop)

	export default {
		props: {
			data: {
				type: String,
				required: true
			}
		},

		data () {
			return {
				form: {
					body: this.data
				},
				editorSettings: {
					modules: {
						imageDrop: true,
					}
				}
			}
		},

		components: {
			VueEditor
		},

		computed: {
			...mapGetters({
				errors: 'errors',
				entryId: 'logbooks/entryId'
			})
		},

		methods: {
			...mapActions({
				update: 'logbooks/update'
			}),

			submit () {
				this.update(this.form)
					.then(response => {
						this.$toast.open({
			                message: response.data.flash,
			                position: 'is-top-right',
			                type: 'is-success'
	            		})

	            		this.cancel()
					}).catch(error => {})
			},

			cancel () {
				this.form.body = ''

				window.events.$emit('logbook-entry:cancel')
			}
		}
	}
</script>