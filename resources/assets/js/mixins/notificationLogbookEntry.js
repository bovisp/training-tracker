export default {
	computed: {
		creator () {
			return this.notification.meta.logbookEntryCreator
		},

		editor () {
			return this.notification.meta.logbookEntryEditor
		},

		creatorName () {
			return `${this.notification.meta.logbookEntryCreator.firstname} ${this.notification.meta.logbookEntryCreator.lastname}`
		},

		apprentice () {
			return this.notification.meta.lessonPackageApprentice
		},

		apprenticeName () {
			return `${this.notification.meta.lessonPackageApprentice.firstname} ${this.notification.meta.lessonPackageApprentice.lastname}`
		},

		objective () {
			return this.notification.meta.objective
		},

		package () {
			return this.notification.meta.lessonPackage.package
		},

		logbookUrl () {
			return `/users/${this.apprentice.id}/logbooks/${this.notification.meta.logbookId}`
		},

		lessonPackageUrl () {
			return `/users/${this.apprentice.id}/userlessons/${this.notification.meta.lessonPackage.id}`
		}
	}
}