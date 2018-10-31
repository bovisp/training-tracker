export const hasNotifications = state => state.unread.length || state.read.length

export const read = state => state.read

export const unread = state => state.unread

export const user = state => state.user