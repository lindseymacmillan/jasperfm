const initialContributors = {
    use_contributor_structure: false,
}
    
export const contributorsReducer = (state = initialContributors, action) => {
switch (action.type) {
    case 'TOGGLE_USE_CONTRIBUTOR_STRUCTURE': 
        return { ...state, use_contributor_structure: !state.use_contributor_structure }
    default:
        return state
}
}