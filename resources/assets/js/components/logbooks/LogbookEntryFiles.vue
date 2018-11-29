<template>
	<div>
		<h3 class="title is-3">{{ trans('app.components.logbooks.files') }}</h3>

		<ul class="ml-4 mb-4" v-if="entry.files.length">
			<li	v-for="file in entry.files" :key="file.id">
				<div class="level">
					<div class="level-left">
						<div class="level-item">
							<i :class="icon(file.codedFilename)" class="mr-2"></i>

							<a :href="`${urlBase}/storage/entries/${userId}/${file.codedFilename}`">
								{{ file.actualFilename }}
							</a>
						</div>

						<div class="level-item">
							<button 
								class="button has-text-danger is-text is-small"
								@click.prevent="removeFile(file.codedFilename)"
							>{{ trans('app.general.buttons.delete') }}</button>
						</div>
					</div>

					<div class="level-right"></div>
				</div>					
			</li>
		</ul>

		<p class="mb-4" v-else>
			{{ trans('app.components.logbooks.nofiles') }}
		</p>

		<button 
			class="has-text-info button is-text"
			v-if="!updating && !completedPackage"
			@click.prevent="updating = true"
		>{{ trans('app.components.logbooks.addfiles') }}</button>

		<template v-if="updating">
			<file-upload />

			<div class="level mt-4">
				<div class="level-left">
					<div class="level-item">
						<button 
							class="button is-small is-info"
							@click.prevent="submit"
						>{{ trans('app.components.logbooks.add') }}</button>
					</div>

					<div class="level-item">
						<button 
							class="button is-small is-text"
							@click.prevent="updating = false"
						>{{ trans('app.general.buttons.cancel') }}</button>
					</div>
				</div>
			</div>
			
		</template>	
	</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	import FileUpload from '../uploads/FileUpload'

	export default {
		components: {
			FileUpload
		},

		data () {
			return {
				updating: false,
				form: {
					files: []
				},
			}
		},

		computed: {
			...mapGetters({
				userId: 'logbooks/userId',
				entry: 'logbooks/entry',
				completedPackage: 'logbooks/completedPackage',
			})
		},

		methods: {
			...mapActions({
				deleteFile: 'logbooks/deleteFile',
				patchFiles: 'logbooks/patchFiles'
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

			removeFile (file) {
				this.$dialog.confirm({
                    title: this.trans('app.components.logbooks.deletefile'),
                    message: this.trans('app.components.logbooks.deletefileconfirm'),
                    confirmText: this.trans('app.components.logbooks.deletefile'),
                    type: 'is-danger',
                    onConfirm: () => this.deleteFile(file)
						.then(response => {
							this.$toast.open({
				                message: this.trans('app.components.logbooks.filedeleted'),
				                position: 'is-top-right',
				                type: 'is-success'
	            			})
						})
						.catch(error => {
							this.$toast.open({
				                message: this.trans('app.components.logbooks.cantdeletefile'),
				                position: 'is-top-right',
				                type: 'is-danger'
	            			})
						})
                })
			},

			submit () {
				this.patchFiles(this.form)
					.then(response => {
						this.$toast.open({
			                message: response.data.flash,
			                position: 'is-top-right',
			                type: 'is-success'
	            		})

	            		this.cancel()
					}).catch(error => {
						this.$toast.open({
			                message: this.trans('app.components.logbooks.cantupdatefiles'),
			                position: 'is-top-right',
			                type: 'is-danger'
	            		})
					})
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