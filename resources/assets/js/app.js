require('./bootstrap');

import Vue from 'vue';
import Buefy from 'buefy'
import store from './store'
import orderBy from 'lodash.orderby'
import forEach from 'lodash.foreach'
import map from 'lodash.map'
import filter from 'lodash.filter'
import find from 'lodash.find'
import assign from 'lodash.assign'

import user from './mixins/user'

import './helpers/interceptors'

Vue.use(Buefy, {
	defaultToastDuration: 5000
})

window.Vue = Vue

window.orderBy = orderBy
window.forEach = forEach
window.map = map
window.filter = filter
window.find = find
window.assign = assign

window.events = new Vue()

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

Vue.component('data-table', require('./components/datatable/Datatable.vue'));
Vue.component('appointment-date', require('./components/AppointmentDate.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('unassigned-user-lessons', require('./components/UnassignedUserLessons.vue'));
Vue.component('user-lesson', require('./components/userlessons/UserLesson.vue'));
Vue.component('logbook', require('./components/logbooks/Logbook.vue')); 
Vue.component('user-errors', require('./components/UserErrors.vue')); 
Vue.component('notifications', require('./components/notifications/Notifications.vue')); 

Vue.mixin(user)

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
