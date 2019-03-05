<template>
	<div class="flex mb-4">
		<b-dropdown class="ml-auto" position="is-bottom-left">
	        <button class="button is-link is-outlined" slot="trigger">
	            <b-icon icon="settings"></b-icon>
	            <b-icon icon="menu-down"></b-icon>
	        </button>

	        <b-dropdown-item>
	            <span class="flex items-center" @click="$emit('entryedit')">
		            <b-icon icon="pencil" class="mr-2"></b-icon>
		            Edit
	            </span>
	        </b-dropdown-item>

	        <b-dropdown-item>
	        	<span class="has-text-danger flex items-center" @click="$emit('entrydelete')">
		            <b-icon icon="delete" class="mr-2"></b-icon>
		            Delete
	            </span>
	        </b-dropdown-item>
	    </b-dropdown>
	</div>
</template>