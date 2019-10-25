const initialPostTypes = {
    post_types: [],
    modal: {
      is_open: false,
      post_type: null,
      post_fields: []
    }
}

Array.prototype.move = function(from, to) {
  this.splice(to, 0, this.splice(from, 1)[0]);
};
    
export const postTypesReducer = (state = initialPostTypes, action) => {
    switch (action.type) {
        case 'ADD_POST_TYPE': 
          return { ...state, post_types: [...state.post_types, action.payload] }
        case 'OPEN_POST_TYPES_MODAL': 
          return { ...state, modal: { ...state.modal, is_open: true, post_type: action.payload.post_type, mode: action.payload.mode } }
        case 'CLOSE_POST_TYPES_MODAL': 
          return { ...state, modal: { ...state.modal, is_open: false } }
        case 'FETCHING_POST_TYPES': 
          return { ...state, is_fetching: true }
        case 'POST_TYPES_RECEIVED': 
          return { ...state, is_fetching: false, post_types: action.payload }
        case 'CREATING_POST_TYPE': 
          return { ...state, is_creating: true }
        case 'POST_TYPE_CREATED': 
          return { ...state, is_creating: false, new_modal_is_open: false }
        case 'GET_POST_TYPE_FIELDS': {
          const postFields = state.post_types[action.payload.post_type].post_fields.slice(0)
          return { ...state, modal: { ...state.modal, post_fields: postFields } }
        }
        case 'ADD_POST_TYPE_FIELD': {
          let postFields = state.modal.post_fields.slice(0)
          postFields[postFields.length] = { ...postFields[postFields.length], label: 'Label', key: 'field_key', is_meta: false, type: 'text', eval: '' }
          return { ...state, modal: { ...state.modal, post_fields: postFields } }
        }
        case 'REMOVE_POST_TYPE_FIELD': {
          let postFields = state.modal.post_fields.slice(0)
          postFields.splice(action.payload.field_index, 1)
          return { ...state, modal: { ...state.modal, post_fields: postFields } }
        }
        case 'MOVE_POST_TYPE_FIELD': {
          let postFields = state.modal.post_fields.slice(0)
          postFields.move(action.payload.from_index, action.payload.to_index)
          return { ...state, modal: { ...state.modal, post_fields: postFields } }
        }
        case 'SET_POST_TYPE_FIELD': {
          let postFields = state.modal.post_fields.slice(0)
          postFields[action.payload.field_index] = { ...postFields[action.payload.field_index], [action.payload.key]: action.payload.value }
          return { ...state, modal: { ...state.modal, post_fields: postFields } }
        }
        default:
            return state
    }
}