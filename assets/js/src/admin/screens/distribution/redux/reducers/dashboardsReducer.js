const initialDashboards = {
    dashboards: [],
    modal: {
      is_open: false,
      mode: null,
      dashboard_id: null
    },
    is_creating: false,
    is_fetching: false,
  }
    
  export const dashboardsReducer = (state = initialDashboards, action) => {
    switch (action.type) {
        case 'SET_LAYOUT': 
          return { ...state, active_layout: action.payload }
        case 'OPEN_DASHBOARDS_MODAL': 
          return { ...state, modal: { ...state.modal, is_open: true, mode: action.payload.mode, dashboard: action.payload.dashboard } }
        case 'CLOSE_DASHBOARDS_MODAL': 
          return { ...state, modal: { ...state.modal, is_open: false } }
        case 'CREATING_DASHBOARD': 
          return { ...state, is_creating: true }
        case 'DASHBOARD_CREATED': 
          return { ...state, is_creating: false, new_modal_is_open: false }
        case 'FETCHING_DASHBOARDS': 
          return { ...state, is_fetching: true }
        case 'DASHBOARDS_RECEIVED': 
          return { ...state, is_fetching: false, dashboards: action.payload }
        default:
          return state
    }
  }