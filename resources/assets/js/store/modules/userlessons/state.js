export default {
	userlesson: {},
	objectives: [],
	logbooks: [],
	lesson: {},
	entry: {},
	logbookId: null,
	allObjectivesComplete: false,
	entryModalActive: false,
	form: {
		completedObjectives: [],
		statuses: {
			p9: null,
			p18: null,
			p30: null,
			p42: null
		}
	},
	statuses: [ 
		{ name: 'Early EG-03', period: 'p9' },
		{ name: 'Late EG-03', period: 'p18' },
		{ name: 'Early EG-04', period: 'p30' },
		{ name: 'Late EG-04', period: 'p42' }
	],
	statusTypes: [
		{ type: 'c', name: 'C - Completed' },
		{ type: 'd', name: 'D - Deferred' },
		{ type: 'e', name: 'E - Exempt' }
	]
}