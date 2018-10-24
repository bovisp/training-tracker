export const setComments = (state, payload) => state.comments = payload

export const addComment = (state, payload) => state.comments.push(payload)

export const updateComment = (state, comment) => assign(find(state.comments, { id: comment.id }), comment)

export const deleteComment = (state, comment) => state.comments = filter(state.comments, comnt => comnt.id !== comment.id)

