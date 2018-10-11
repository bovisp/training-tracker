<template>
    <div 
        class="dragndrop"
        :class="{ 'dragndrop--dragged': isDraggedOver }"
        @dragover.prevent="enter"
        @dragenter.prevent="enter"
        @dragleave.prevent="leave"
        @dragend.prevent="leave"
        @drop.prevent="drop"
    >
        <input 
            type="file" 
            name="files[]" 
            id="file" 
            multiple
            class="dragndrop__input" 
            @change="select"
            ref="input"
        >

        <label 
            for="file"
            class="dragndrop__header" 
            :class="{ 'dragndrop__header--compact': files.length >= 1 }"
        >
            <strong>Drag files here</strong> or click to select files
        </label>

        <uploads 
            :files="files"
        />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import Uploads from './Uploads'

    export default {
        data() {
            return {
                files: [],
                isDraggedOver: false
            }
        },

        components: {
            Uploads
        },

        computed: {
            ...mapGetters({
                'logbookId': 'logbooks/logbookId',
                'userId': 'logbooks/userId'
            })
        },

        methods: {
            enter (e) {
                this.isDraggedOver = true
            },

            leave (e) {
                this.isDraggedOver = false
            },

            drop (e) {
                this.leave()

                this.addFiles(e.dataTransfer.files)
            },

            select (e) {
                this.addFiles(this.$refs.input.files)
            },

            addFiles (files) {
                var i, file

                for (i = 0; i < files.length; i++) {
                    file = files[i]

                    this.storeMeta(file)
                        .then(
                            fileObject => {
                                this.upload(fileObject)
                            },
                            fileObject => {
                                fileObject.failed = true
                            }
                        )
                }
            },

            storeMeta (file) {
                let fileObject = this.generateFileObject(file)

                return axios.post(`/users/${this.userId}/logbooks/${this.logbookId}/files/meta`, {
                    name: file.name
                })
                .then(
                    response => {
                        fileObject.id = response.data
                        
                        return fileObject
                    },
                    () => {
                        Promise.reject(fileObject)
                    }
                )
            },

            generateFileObject (file) {
                let fileObjectIndex = this.files.push({
                    id: null,
                    file,
                    progress: 0,
                    failed: false,
                    loadedBytes: 0,
                    totalBytes: 0,
                    timeStarted: (new Date).getTime(),
                    secondsRemaining: 0,
                    finished: false,
                    cancelled: false,
                    xhr: null,
                    codedFilename: null
                }) - 1

                return this.files[fileObjectIndex]
            },

            upload (fileObject) {
                let form = new FormData()

                form.append('file', fileObject.file)
                form.append('id', fileObject.id)

                window.events.$emit('upload:initialized')

                axios.post(`/users/${this.userId}/logbooks/${this.logbookId}/files/upload`, form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    cancelToken: new axios.CancelToken(function executor(c) {
                        fileObject.xhr = c;
                    }),
                    onUploadProgress: function(progressEvent) {
                        window.events.$emit('upload:progress', fileObject, progressEvent)
                    }
                })
                .then(function({ data }) {
                    fileObject.codedFilename = data.codedFilename
                    fileObject.actualFilename = data.actualFilename

                    window.events.$emit('upload:finished', fileObject)
                })
                .catch(function(error) {
                    if (!fileObject.cancelled) {
                        window.events.$emit('upload:failed', fileObject)

                        if (error.response.status === 422) {
                            window.events.$emit('upload:no-validate', fileObject, error.response.data.errors.file[0])
                        }
                    }
                })
            }
        }
    }
</script>