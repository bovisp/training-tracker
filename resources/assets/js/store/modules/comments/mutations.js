export const setComments = (state, payload) => state.comments = payload

export const addComment = (state, payload) => state.comments.push(payload)

export const updateComment = (state, comment) => _.assign(_.find(state.comments, { id: comment.id }), comment)

export const deleteComment = (state, comment) => state.comments = state.comments.filter(comnt => comnt.id !== comment.id)