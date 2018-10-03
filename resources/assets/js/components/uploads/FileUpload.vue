<template>
    <div class="dragndrop">
        <input 
            type="file" 
            name="files[]" 
            id="file" 
            multiple
            class="dragndrop__input" 
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
                
            }
        },

        methods: {
            
        }
    }
</script>