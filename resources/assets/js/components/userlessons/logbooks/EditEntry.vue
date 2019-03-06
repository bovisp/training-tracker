<template>
	<div class="mb-4">
		<vue-editor 
			v-model="form.body"
			:editorOptions="editorSettings"
		></vue-editor>

		<p 
			v-if="errors.body"
			v-text="errors.body[0]"
			class="has-text-danger"
			style="margin-top: 80px; margin-bottom: -50px;" 
		></p>

		<div class="flex mt-4">
			<button
				@click.prevent="$emit('entryupdate', form)"
				class="button is-info mr-4"
			>{{ trans('app.general.buttons.submit') }}</button>

			<button
				@click.prevent="$emit('entrycancel')"
				class="button is-text"
			>{{ trans('app.general.buttons.cancel') }}</button>
		</div>
	</div>
</template>

<script>
	import { VueEditor, Quill } from 'vue2-editor'
	import { ImageDrop } from 'quill-image-drop-module'
	import { mapActions, mapGetters } from 'vuex'

	Quill.register('modules/imageDrop', ImageDrop)

	export default {
		props: {
			data: {
				type: String,
				required: true
			}
		},

		data () {
			return {
				form: {
					body: this.data
				},
				editorSettings: {
					modules: {
						imageDrop: true,
					}
				}
			}
		},

		components: {
			VueEditor
		},

		computed: {
			...mapGetters({
				errors: 'errors',
			})
		}
	}
</script>