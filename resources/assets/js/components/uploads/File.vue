<template>
	<div class="dragndrop__file">
		<div class="progress">
			<div 
				class="progress__label"
			>
				{{ file.file.name }} 

				<span
					v-if="!file.failed && !file.finished && !file.cancelled"
				>({{ file.secondsRemaining }} seconds remaining)</span>
			</div>

			<div 
				class="progress__fill" 
				:style="{ 'width': file.progress + '%' }"
				:class="{ 
					'progress__fill--finished': file.finished,
					'progress__fill--failed': file.failed || file.cancelled
				}"
			></div>

			<div 
				class="progress__percentage"
			>
				<span v-if="file.failed">Failed</span>

				<span v-if="file.finished">Complete</span>

				<span v-if="file.cancelled">Cancelled</span>

				<span v-if="!file.finished && !file.failed && !file.cancelled">
					{{ file.progress }}%
				</span>
			</div>

			<a 
				href="#"
				class="progress__cancel" 
				v-if="!file.finished && !file.cancelled && !file.failed"
				@click.prevent="cancelUpload"
			>Cancel</a>

			<p
				v-if="file.failed"
				class="progress__error has-text-danger is-size-7 mb-2"
			>{{ errorMessage }}</p>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			file: {
				type: Object,
				required: true
			}
		}, 

		data () {
			return {
				errorMessage: ''
			}
		},

		methods: {
			updateFileUploadProgress (fileObject, progressEvent) {
				if (!progressEvent.lengthComputable) {
					return
				}

				fileObject.loadedBytes = progressEvent.loaded
				fileObject.totalBytes = progressEvent.total

				fileObject.progress = Math.ceil((progressEvent.loaded / progressEvent.total) * 100)
			},

			cancelUpload () {
				this.file.xhr()

				this.file.cancelled = true
			}
		},

		mounted () {
			window.events.$on('upload:progress', (fileObject, progressEvent) => {
				this.updateFileUploadProgress(fileObject, progressEvent)
			})

			window.events.$on('upload:finished', (fileObject, e) => {
				if (fileObject.id === this.file.id) {
					this.file.finished = true
				}
			})

			window.events.$on('upload:failed', (fileObject, e) => {
				if (fileObject.id === this.file.id) {
					this.file.failed = true
				}
			})

			window.events.$on('upload:no-validate', (fileObject, message) => {
				if (fileObject.id === this.file.id) {
					this.errorMessage = message
				}
			})
		}
	}
</script>