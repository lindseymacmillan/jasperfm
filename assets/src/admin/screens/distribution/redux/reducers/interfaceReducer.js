const initialInterface = {
  layouts: [
    {
      slug: 'general',
      label: 'General'
    },
    {
      slug: 'dashboards',
      label: 'Dashboards'
    },
    {
      slug: 'post_types',
      label: 'Post Types'
    },
    {
      slug: 'contributors',
      label: 'Contributors'
    },
    {
      slug: 'bulk_actions',
      label: 'Bulk Actions'
    }
  ],
  active_layout: 'general'
}
  
export const interfaceReducer = (state = initialInterface, action) => {
  switch (action.type) {
      case 'SET_LAYOUT': 
        return { ...state, active_layout: action.payload }
      default:
        return state
  }
}