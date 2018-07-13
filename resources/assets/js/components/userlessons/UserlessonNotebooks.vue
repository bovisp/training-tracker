<template>
	<div>
		<h3 class="title is-3 mt-16">
			Notebooks
		</h3>

		<ul class="box">
			<li v-for="(notebook, index) in notebooks" :key="notebook.id">
				<p>
					<strong>{{ notebook.number }}</strong> - {{ notebook.name }}
				</p>

				<div class="mt-4">
					<button class="button is-info is-small">
						Edit notebook
					</button>

					<small class="has-text-grey">
						Entries: 0 | Last modified by: Some person
					</small>
				</div>

				<hr v-if="index !== (notebooks.length - 1)">
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		computed: {
			notebooks: {
				get () {
					return this.$store.state.userlessons.userlesson.notebooks
				}
			}
		},
	}
</script>