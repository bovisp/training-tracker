require('./bootstrap');

import Vue from 'vue';
import Buefy from 'buefy'
import fecha from 'fecha'
import store from './store'

Vue.use(Buefy, {
	defaultToastDuration: 5000
})

window.Vue = Vue

window.events = new Vue()

window.fecha = fecha

/**
 * You first need to create a formatting function to pad numbers to two digits…
 **/
function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}

/**
 * …and then create the method to output the date string as desired.
 * Some people hate using prototypes this way, but if you are going
 * to apply this to more than one Date object, having it as a prototype
 * makes sense.
 **/
Date.prototype.toMysqlFormat = function() {
    return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
};

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
Vue.component('user-errors', require('./components/UserErrors.vue'));
Vue.component('appointment-date', require('./components/AppointmentDate.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('unassigned-user-lessons', require('./components/UnassignedUserLessons.vue'));
Vue.component('user-lesson', require('./components/userlessons/UserLesson.vue'));
Vue.component('user-lesson-status', require('./components/userlessons/UserLessonStatus.vue'));
Vue.component('user-lesson-objectives', require('./components/userlessons/UserLessonObjectives.vue'));

/**
 * Instantiates the application Vue instance that can be utilized on any view
 * in Laravel as long as an element with an id of #app is present on page.
 * 
 * @type {Vue}
 */
const app = new Vue({
    el: '#app',
    store
});
