require('./bootstrap');

import Vue from 'vue';

window.Vue = Vue;

/**
 * Gives Vue access to the Laravel translation strings on a per language basis.
 * 
 * @param  {string} key The translation string key.
 * 
 * @return {string}     The translation string value.
 */
Vue.prototype.trans = (key) => {
	let paths = key.split('.'),
	    current = window.trans,
        i;

	for (i = 0; i < paths.length; ++i) {
		if (current[paths[i]] == undefined) {
			return undefined;
		} else {
			current = current[paths[i]];
		}
	}
	
	return current;
}

Vue.component('datatable', require('./components/Datatable.vue'));

/**
 * Instantiates the application Vue instance that can be utilized on any view
 * in Laravel as long as an element with an id of #app is present on page.
 * 
 * @type {Vue}
 */
const app = new Vue({
    el: '#app'
});
