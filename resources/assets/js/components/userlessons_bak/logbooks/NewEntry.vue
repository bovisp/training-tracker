<template>
	<div>
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
				<file-upload 
					:logbook-id="logbookId"
				/>

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
					>{{ trans('app.general.buttons.submit') }}</button>
				</div>

				<div class="level-item">
					<button
						@click.prevent="cancel"
						class="button is-text"
					>{{ trans('app.general.buttons.cancel') }}</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { VueEditor, Quill } from 'vue2-editor'
	import { ImageDrop } from 'quill-image-drop-module'
	import { mapActions, mapGetters } from 'vuex'
	import FileUpload from '../../uploads/FileUpload'

	Quill.register('modules/imageDrop', ImageDrop)

	export default {
		props: {
			logbook: {
				required: true,
				type: Number 
			}
		},

		data () {
			return {
				form: {
					body: '',
					files: []
				},
				editorSettings: {
					modules: {
						imageDrop: true,
					}
				},
				addFiles: false,
				logbookId: this.logbook
			}
		},

		components: {
			VueEditor,
			FileUpload
		},

		computed: {
			...mapGetters({
				errors: 'errors',
				userlesson: 'userlessons/userlesson'
			})
		},

		methods: {
			...mapActions({
				store: 'userlessons/storeEntry',
				fetchEntry: 'userlessons/fetchEntry',
				fetchLogbooks: 'userlessons/fetchLogbooks'
			}),

			async submit () {
				let response = await this.store({data: this.form, logbookId: this.logbookId})

				if (response.status === 200) {
					await this.fetchLogbooks(this.userlesson.id)

					await this.fetchEntry(response.data.entry)

            		this.cancel()

            		this.$toast.open({
		                message: response.data.flash,
		                position: 'is-top-right',
		                type: 'is-success'
            		})
				}

				if (response.status === 422) {
					this.$toast.open({
		                message: response.data.message,
		                position: 'is-top-right',
		                type: 'is-danger'
	        		})
				}
			},

			cancel () {
				this.logbookId = false

				this.form.body = ''
				this.form.files = []

				window.events.$emit('entrycreated')
			}
		},

		mounted () {
			window.events.$on('upload:finished', fileObject => {
				this.form.files.push(fileObject)
			})
		}
	}
</script>