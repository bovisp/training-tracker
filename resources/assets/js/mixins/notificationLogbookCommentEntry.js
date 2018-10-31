export default {
	computed: {
		creator () {
			return this.notification.meta.logbookCommentEntryCreator
		},

		editor () {
			return this.notification.meta.logbookCommentEntryEditor
		},

		creatorName () {
			return `${this.notification.meta.logbookCommentEntryCreator.firstname} ${this.notification.meta.logbookCommentEntryCreator.lastname}`
		},

		editorName () {
			return `${this.notification.meta.logbookCommentEntryEditor.firstname} ${this.notification.meta.logbookCommentEntryEditor.lastname}`
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
			return `/users/${this.apprentice.id}/logbooks/${this.notification.meta.logbookId}?entry=${this.notification.meta.logbookEntryId}&comment=${this.notification.meta.logbookCommentEntryId}`
		},

		lessonPackageUrl () {
			return `/users/${this.apprentice.id}/userlessons/${this.notification.meta.lessonPackage.id}`
		}
	}
}