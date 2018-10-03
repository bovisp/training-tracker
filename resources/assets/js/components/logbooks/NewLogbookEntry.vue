<template>
	<div>
		<button 
			v-if="!creating"
			@click.prevent="creating = true"
			class="button is-info"
		>New logbook entry</button>

		<template v-else>
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

			<div class="level" style="margin-top: 80px;">
				<div class="level-left">
					<div class="level-item">
						<button
							@click.prevent="submit"
							class="button is-info"
						>Create</button>
					</div>

					<div class="level-item">
						<button
							@click.prevent="cancel"
							class="button is-text"
						>Cancel</button>
					</div>
				</div>
			</div>

			<file-upload />
		</template>
	</div>
</template>

<script>
	import { VueEditor, Quill } from 'vue2-editor'
	import { ImageDrop } from 'quill-image-drop-module'
	import { mapActions, mapGetters } from 'vuex'
	import FileUpload from '../uploads/FileUpload'

	Quill.register('modules/imageDrop', ImageDrop)

	export default {
		props: {
			endpoint: {
				type: String,
				required: true
			}
		},

		data () {
			return {
				creating: false,
				form: {
					body: ''
				},
				editorSettings: {
					modules: {
						imageDrop: true,
					}
				}
			}
		},

		components: {
			VueEditor,
			FileUpload
		},

		computed: {
			...mapGetters({
				errors: 'errors'
			})
		},

		methods: {
			...mapActions({
				store: 'logbooks/store'
			}),

			submit () {
				this.store({
					data: this.form,
					endpoint: this.endpoint
				})
					.then(response => {
						this.$toast.open({
			                message: response.data.flash,
			                position: 'is-top-right',
			                type: 'is-success'
	            		})

	            		this.cancel()
					}).catch(error => {

					})
			},

			cancel () {
				this.creating = false

				this.form.body = ''
			}
		}
	}
</script>