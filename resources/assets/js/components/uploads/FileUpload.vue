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
        >
            <strong>Drag files here</strong> or click to select files
        </label>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        data() {
            return {
                files: [],
                isDraggedOver: false
            }
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

                // emit upload init

                axios.post(`/users/${this.userId}/logbooks/${this.logbookId}/files/upload`, form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    cancelToken: new axios.CancelToken(function executor(c) {
                        fileObject.xhr = c;
                    }),
                    onUploadProgress: function(progressEvent) {
                        console.log(progressEvent)
                        // EventBus.$emit('progress', fileObject, progressEvent)
                    }
                })
                .then(function({ data }) {
                    fileObject.codedFilename = data
                    window.events.$emit('upload:finished', fileObject)
                })
                .catch(function(e) {
                    // if (!fileObject.canceled) {
                    //     EventBus.$emit('failed', fileObject)
                    // }
                })
            }
        }
    }
</script>