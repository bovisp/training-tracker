<template>
	<div>
		<h3 class="title is-3">Files</h3>

		<ul class="ml-4 mb-4" v-if="entry.files.length">
			<li	v-for="file in entry.files" :key="file.id">
				<div class="level">
					<div class="level-left">
						<div class="level-item">
							<i :class="icon(file.codedFilename)" class="mr-2"></i>

							<a :href="`/storage/entries/${userId}/${file.codedFilename}`">
								{{ file.actualFilename }}
							</a>
						</div>

						<div class="level-item">
							<button 
								class="button has-text-danger is-text is-small"
								@click.prevent="removeFile(file.codedFilename)"
							>Delete</button>
						</div>
					</div>

					<div class="level-right"></div>
				</div>					
			</li>
		</ul>

		<p class="mb-4" v-else>There are no files for this entry.</p>

		<button 
			class="is-info button is-small"
			v-if="!updating"
			@click.prevent="updating = true"
		>Add files</button>

		<template v-else>
			<file-upload />

			<div class="level mt-4">
				<div class="level-left">
					<div class="level-item">
						<button 
							class="button is-small is-info"
							@click.prevent="submit"
						>Add</button>
					</div>

					<div class="level-item">
						<button 
							class="button is-small is-text"
							@click.prevent="updating = false"
						>Cancel</button>
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
						return 'far fa-file-pdf'

					case 'doc':
					case 'docx':
						return 'far fa-file-word'

					case 'xls':
					case 'xlsx':
						return 'far fa-file-excel'

					case 'ppt':
					case 'pptx':
						return 'far fa-file-powerpoint'

					case 'jpeg':
					case 'jpg':
					case 'bmp':
					case 'tiff':
					case 'png':
					case 'gif':
						return 'far fa-image'

					case 'mp4':
					case 'avi':
					case 'wmv':
					case 'mov':
						return 'far fa-file-video'

					default:
						return 'far fa-file'
				}
			},

			removeFile (file) {
				this.$dialog.confirm({
                    title: 'Delete file',
                    message: 'Are you sure you want to <b>delete</b> this file?',
                    confirmText: 'Delete entry',
                    type: 'is-danger',
                    onConfirm: () => this.deleteFile(file)
						.then(response => {
							this.$toast.open({
				                message: 'File successfully deleted',
				                position: 'is-top-right',
				                type: 'is-success'
	            			})
						})
						.catch(error => {
							this.$toast.open({
				                message: 'You are not authorized to delete this file.',
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
			                message: 'You are not authorized to update files for this logbook entry',
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