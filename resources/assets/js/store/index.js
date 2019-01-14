import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

import userlessons from './modules/userlesson'
import comments from './modules/comments'
import logbooks from './modules/logbooks'
import notifications from './modules/notifications'

export default new Vuex.Store({
	state, 
	mutations, 
	actions,
	getters,
	modules: {
		userlessons,
		comments,
		logbooks,
		notifications 
	} 
})