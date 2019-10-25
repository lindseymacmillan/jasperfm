import qs from 'qs';
import axios from 'axios';

const route = 'jasperfm/v1/dashboards';

export const openDashboardsModal = (mode, dashboard) => {
    return {
        type: 'OPEN_DASHBOARDS_MODAL',
        payload: {
            mode: mode,
            dashboard: dashboard
        }
    }
}

export const closeDashboardsModal = () => {
    return {
        type: 'CLOSE_DASHBOARDS_MODAL',
    }
}

export const creatingDashboard = () => {
    return {
        type: 'CREATING_DASHBOARD'
    }
}

export const dashboardCreated = () => {
    return {
        type: 'DASHBOARD_CREATED'
    }
}

export const deletingDashboard = () => {
    return {
        type: 'DELETING_DASHBOARD'
    }
}

export const dashboardDeleted = () => {
    return {
        type: 'DASHBOARD_CREATED'
    }
}

export const fetchingDashboards = () => {
    return {
        type: 'FETCHING_DASHBOARDS'
    }
}

export const dashboardsReceived = (dashboards) => {
    return {
        type: 'DASHBOARDS_RECEIVED',
        payload: dashboards
    }
}

export const createDashboard = (args) => {

    return function(dispatch) {

        dispatch(creatingDashboard())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'create',
                'payload': {
                    'name': args.name,
                    'description': args.description,
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            // if (args.goTo == true) {
            //     window.location.href = window.location.origin + '/wp-admin/post.php?post=' + response.data + '&action=edit';
            // } else {
            dispatch(dashboardCreated(response.data));
            dispatch(closeDashboardsModal());
            dispatch(getDashboards());
            // }
            console.log(response);
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const updateDashboard = (termId, args) => {

    return function(dispatch) {

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'update',
                'payload': {
                    'term_id': termId,
                    'name': args.name,
                    'description': args.description,
                    'supported_post_types': args.supportedPostTypes,
                    'linked_content': args.linkedContent
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            // if (args.goTo == true) {
            //     window.location.href = window.location.origin + '/wp-admin/post.php?post=' + response.data + '&action=edit';
            // } else {
            dispatch(closeDashboardsModal());
            dispatch(getDashboards());
            // }
            console.log(response);
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const deleteDashboard = (term_id) => {

    return function(dispatch) {

        dispatch(deletingDashboard())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'delete',
                'payload': {
                    'term_id': term_id,
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            // if (args.goToDashboard == true) {
            //     window.location.href = window.location.origin + '/wp-admin/post.php?post=' + response.data + '&action=edit';
            // } else {
            //     dispatch(dashboardCreated(response.data));
            //     dispatch(setQueryString(''));
            dispatch(closeDashboardsModal())
            dispatch(getDashboards())
            // }
            console.log(response);
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const getDashboards = () => {

    return function(dispatch) {

        dispatch(fetchingDashboards())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'query',
                'payload': {
                    'term_id': 'sample',
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            console.log(response);
            dispatch(dashboardsReceived(response.data.return));
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}