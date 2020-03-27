require('./bootstrap');

import 'core-js/es/object/assign'
import 'core-js/es/symbol/iterator'

import Vue from 'vue'
import Buefy from 'buefy'
import store from './store'
import orderBy from 'lodash.orderby'
import forEach from 'lodash.foreach'
import map from 'lodash.map'
import filter from 'lodash.filter'
import find from 'lodash.find'
import assign from 'lodash.assign'
import get from 'lodash.get'
import concat from 'lodash.concat' 

window._ = require('lodash')

import user from './mixins/user'
import getUrlBase from './mixins/urlBase'
import error from './mixins/errors'
import helpers from './mixins/helpers'

import './helpers/interceptors'

import DataTable from './components/datatable/Datatable.vue';
import AppointmentDate from './components/users/AppointmentDate.vue';
import Deactivation from './components/users/Deactivation.vue';
import Deactivations from './components/users/deactivations/Deactivations.vue';
import Activation from './components/users/Activation.vue';
import Flash from './components/Flash.vue';
import UnassignedUserLessons from './components/users/UnassignedUserLessons.vue';
import Userlesson from './components/userlessons/Userlesson.vue';
import UserErrors from './components/UserErrors.vue';
import Notifications from './components/notifications/Notifications.vue';
import UnreadNotifications from './components/notifications/UnreadNotifications.vue';

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
 * Responsive Bulma navbar
 **/
 document.addEventListener('DOMContentLoaded', () => {

  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});

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

Vue.component('data-table', DataTable);
Vue.component('appointment-date', AppointmentDate);
Vue.component('deactivation', Deactivation);
Vue.component('deactivations', Deactivations);
Vue.component('activation', Activation);
Vue.component('flash', Flash);
Vue.component('unassigned-user-lessons', UnassignedUserLessons);
Vue.component('userlesson', Userlesson);
Vue.component('user-errors', UserErrors); 
Vue.component('notifications', Notifications); 
Vue.component('unread-notifications', UnreadNotifications); 

Vue.mixin(user)
Vue.mixin(error)
Vue.mixin(getUrlBase)
Vue.mixin(helpers)

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
