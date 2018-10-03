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
        {{ isDraggedOver }}

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
    export default {
        data() {
            return {
                files: [],
                isDraggedOver: false
            }
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
                console.log(e.dataTransfer.files)
            },

            select (e) {
                console.log(this.$refs.input.files)
            }
        }
    }
</script>