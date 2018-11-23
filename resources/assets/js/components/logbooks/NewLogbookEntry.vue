<template>
	<div>
		<button 
			v-if="!creating"
			@click.prevent="creating = true"
			class="button is-info"
		>{{ trans('app.components.logbooks.newentry') }}</button>

		<template v-else>
			<vue-editor 
				v-model="form.body"
				:editorOptions="editorSettings"
			></vue-editor>

			<p 
				v-if="errors.body"
				v-text="errors.body[0]"
				class="mt-4 mb-4 has-text-danger"
			></p>
			
			<div class="mt-4 mb-4">
				<template v-if="addFiles">
					<file-upload />

					<button class="button is-text is-small mt-2" @click="addFiles = false">
						{{ trans('app.components.logbooks.canceladdfiles') }}
					</button>
				</template>

				<template v-else>
					<button class="button is-text" @click="addFiles = true">
						<i class="mdi mdi-plus"></i> {{ trans('app.components.logbooks.addfiles') }}
					</button>
				</template>
			</div>
			
			<div class="level">
				<div class="level-left">
					<div class="level-item">
						<button
							@click.prevent="submit"
							class="button is-info"
						>{{ trans('app.general.buttons.create') }}</button>
					</div>

					<div class="level-item">
						<button
							@click.prevent="cancel"
							class="button is-text"
						>{{ trans('app.general.buttons.cancel') }}</button>
					</div>
				</div>
			</div>
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
					body: '',
					files: []
				},
				editorSettings: {
					modules: {
						imageDrop: true,
					}
				},
				addFiles: false
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
					}).catch(error => {})
			},

			cancel () {
				this.creating = false

				this.form.body = ''
				this.form.files = []
			}
		},

		mounted () {
			window.events.$on('upload:finished', fileObject => {
				this.form.files.push(fileObject)
			})
		}
	}
</script>