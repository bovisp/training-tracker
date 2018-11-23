<template>
	<div>
		<div class="dragndrop__status" v-if="files.length">
			<ul class="list-inline">
				<li class="list-inline__item">
					{{ trans('app.components.uploads.numberoffiles') }} {{ files.length }}
				</li>

				<li class="list-inline__item">
					{{ trans('app.components.uploads.percentage') }} {{ overallProgress }}%
				</li>

				<li class="list-inline__item list-inline__item--last">
					{{ trans('app.components.uploads.timeremaining') }} {{ timeRemaining }}
				</li>
			</ul>
		</div>
		
		<file 
			v-for="file in files"
			:key="file.id"
			:file="file"
		/>
	</div>
</template>

<script>
	import File from './File'
	import timeremaining from '../../helpers/timeremaining'
	import pad from '../../helpers/pad'

	export default {
		props: {
			files: {
				required: true,
				type: Array
			}
		},

		data () {
			return {
				overallProgress: 0,
				interval: null,
				secondsRemaining: 0,
				timeRemaining: this.trans('app.components.uploads.calculating')
			}
		},

		components: {
			File
		},

		methods: {
			unfinishedFiles () {
				let i
				let files = []

				for (i = 0; i < this.files.length; i++) {
					if (this.files[i].finished || this.files[i].cancelled) {
						continue
					}

					files.push(this.files[i])
				}

				return files
			},

			updateOverallProgress () {
				let unfinishedFiles = this.unfinishedFiles()
				let totalProgress = 0

				forEach(unfinishedFiles, file => {
					totalProgress += file.progress
				})

				this.overallProgress = parseInt(totalProgress / unfinishedFiles.length || 0)
			},

			updateTimeRemaining () {
				let minutes, seconds

				this.secondsRemaining = 0

				forEach(this.unfinishedFiles(), file => {
					file.secondsRemaining = timeremaining.calculate(
						file.totalBytes , file.loadedBytes , file.timeStarted 
					)

					this.secondsRemaining += file.secondsRemaining
				})

				minutes = Math.floor(this.secondsRemaining / 60)

				seconds = this.secondsRemaining - minutes * 60

				this.timeRemaining = pad.left('00', minutes) + ':' + pad.left('00', seconds)
			}
		},

		mounted () {
			window.events.$on('upload:progress', (fileObject, progressEvent) => {
				this.updateOverallProgress()
			})

			window.events.$on('upload:initialized', () => {
				if (!this.interval) {
					this.interval = setInterval(() => {
						if (this.unfinishedFiles().length === 0) {
							this.updateOverallProgress()

							clearInterval(this.interval)

							this.interval = null
						}

						this.updateTimeRemaining()
					}, 1000)
				}
			})
		}
	}
</script>