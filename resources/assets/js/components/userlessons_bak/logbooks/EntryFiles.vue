<template>
	<div>
		<ul class="ml-4 mb-4" v-if="hasFiles">
			<li	
				v-for="file in entry.files" 
				:key="file.id"
				class="flex items-center"
			>
				<i :class="icon(file.codedFilename)" class="mr-2"></i>

				<a :href="`${urlBase}/storage/entries/${userlesson.user.id}/${file.codedFilename}`">
					{{ file.actualFilename }}
				</a>
			
				<button 
					class="button has-text-danger is-text is-small"
					@click.prevent="remove(file.codedFilename)"
				>{{ trans('app.general.buttons.delete') }}</button>
			</li>
		</ul>

		<p class="mb-4 has-text-info" v-else>
			{{ trans('app.components.logbooks.nofiles') }}
		</p>

		<button 
			class="has-text-info button is-text"
			v-if="!updating && !isCompleted"
			@click.prevent="updating = true"
		>{{ trans('app.components.logbooks.addfiles') }}</button>

		<template v-if="updating">
			<FileUpload />

			<div class="flex mt-4">
				<button 
					class="button is-small is-info mr-4"
					@click.prevent="submit"
				>{{ trans('app.components.logbooks.add') }}</button>

				<button 
					class="button is-small is-text"
					@click.prevent="updating = false"
				>{{ trans('app.general.buttons.cancel') }}</button>
			</div>
		</template>	
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import FileUpload from '../../uploads/FileUpload'

	export default {
		props: {
			isCompleted: {
				required: true,
				type: Boolean
			}
		},

		data () {
			return {
				updating: false,
				form: {
					files: []
				}
			}
		},

		components: {
			FileUpload
		},

		computed: {
			...mapGetters({
				entry: 'userlessons/entry',
				userlesson: 'userlessons/userlesson'
			}),

			hasFiles () {
				return typeof this.entry.files !== 'undefined' && Object.keys(this.entry.files).length
			}
		},

		methods: {
			...mapActions({
				deleteFile: 'userlessons/deleteFile',
				patchFiles: 'userlessons/patchFiles'
			}),

			icon (fileName) {
				let fileExtension = fileName.split('.')[1].toLowerCase()

				switch (fileExtension) {
					case 'pdf':
						return 'mdi mdi-file-pdf'

					case 'doc':
					case 'docx':
						return 'mdi mdi-file-word'

					case 'xls':
					case 'xlsx':
						return 'mdi mdi-file-excel'

					case 'ppt':
					case 'pptx':
						return 'mdi mdi-file-powerpoint'

					case 'jpeg':
					case 'jpg':
					case 'bmp':
					case 'tiff':
					case 'png':
					case 'gif':
						return 'mdi mdi-file-image'

					case 'mp4':
					case 'avi':
					case 'wmv':
					case 'mov':
						return 'mdi mdi-file-video'

					default:
						return 'mdi mdi-file'
				}
			},

			async removeFile (file) {
				let response = await this.deleteFile(file)

				this.$toast.open({
	                message: this.trans('app.components.logbooks.filedeleted'),
	                position: 'is-top-right',
	                type: 'is-success'
    			})

    			this.cancel()
			},

			remove (file) {
				this.$dialog.confirm({
                    title: this.trans('app.components.logbooks.deletefile'),
                    message: this.trans('app.components.logbooks.deletefileconfirm'),
                    confirmText: this.trans('app.components.logbooks.deletefile'),
                    type: 'is-danger',
                    onConfirm: () => this.removeFile(file)
                })
			},

			async submit () {
				let response = await this.patchFiles(this.form)

				if (response.status === 200) {
					this.$toast.open({
		                message: response.data.flash,
		                position: 'is-top-right',
		                type: 'is-success'
            		})

            		this.cancel()
				} else {
					this.$toast.open({
		                message: this.trans('app.components.logbooks.cantupdatefiles'),
		                position: 'is-top-right',
		                type: 'is-danger'
            		})
				}
			},

			cancel () {
				this.updating = false

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