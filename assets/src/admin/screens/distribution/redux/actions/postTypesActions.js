import qs from 'qs';
import axios from 'axios';

const route = 'jasperfm/v1/post_types';

export const openPostTypesModal = (mode, postType) => {
    return {
        type: 'OPEN_POST_TYPES_MODAL',
        payload: {
            mode: mode,
            post_type: postType
        }
    }
}

export const closePostTypesModal = () => {
    return {
        type: 'CLOSE_POST_TYPES_MODAL'
    }
}

export const fetchingPostTypes = () => {
    return {
        type: 'FETCHING_POST_TYPES'
    }
}

export const postTypesReceived = (post_types) => {
    return {
        type: 'POST_TYPES_RECEIVED',
        payload: post_types
    }
}

export const creatingPostType = () => {
    return {
        type: 'CREATING_POST_TYPE'
    }
}

export const postTypeDeleted = () => {
    return {
        type: 'POST_TYPE_DELETED'
    }
}

export const deletingPostType = () => {
    return {
        type: 'DELETING_POST_TYPE'
    }
}

export const postTypeCreated = () => {
    return {
        type: 'POST_TYPE_CREATED'
    }
}

export const createPostType = (args) => {

    return function(dispatch) {

        dispatch(creatingPostType())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'create',
                'payload': {
                    'name': args.name,
                    'singular_name': args.singular_name,
                    'plural_name': args.plural_name,
                    'show_in_menu': args.show_in_menu
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            dispatch(postTypeCreated());
            dispatch(closePostTypesModal())
            dispatch(getPostTypes());
            console.log(response);
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const deletePostType = (name) => {

    return function(dispatch) {

        dispatch(deletingPostType())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'delete',
                'payload': {
                    'name': name,
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            dispatch(postTypeDeleted());
            console.log(response);
            dispatch(closePostTypesModal());
            dispatch(getPostTypes());
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const updatePostType = (args) => {

    return function(dispatch) {

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'update',
                'payload': {
                    'name': args.name,
                    'singular_name': args.singular_name,
                    'plural_name': args.plural_name,
                    'show_in_menu': args.show_in_menu
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            console.log(response);
            dispatch(closePostTypesModal());
            dispatch(getPostTypes());
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const getPostTypes = () => {

    return function(dispatch) {

        dispatch(fetchingPostTypes())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'query',
                'payload': {
                    'name': 'sample',
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            console.log(response);
            dispatch(postTypesReceived(response.data.return));
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}

export const getPostTypeFields = (postType) => {
    return {
        type: 'GET_POST_TYPE_FIELDS',
        payload: {
            post_type: postType
        }
    }
}

export const addPostTypeField = () => {
    return {
        type: 'ADD_POST_TYPE_FIELD'
    }
}

export const removePostTypeField = (fieldIndex) => {
    return {
        type: 'REMOVE_POST_TYPE_FIELD',
        payload: {
            field_index: fieldIndex
        }
    }
}

export const movePostTypeField = (fromIndex, toIndex) => {
    return {
        type: 'MOVE_POST_TYPE_FIELD',
        payload: {
            from_index: fromIndex,
            to_index: toIndex
        }
    }
}

export const setPostTypeField = (args) => {
    return {
        type: 'SET_POST_TYPE_FIELD',
        payload: {
            field_index: args.field_index,
            key: args.key,
            value: args.value,
        }
    }
}

export const updatePostTypeFields = (postType, postFields) => {

    return function(dispatch) {

        //dispatch(fetchingPostTypes())

        return axios.post(wpApiSettings.root + route,
            qs.stringify({
                'action': 'update_fields',
                'payload': {
                    'post_type': postType,
                    'post_fields': postFields
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            console.log(response);
            dispatch(closePostTypesModal())
            dispatch(getPostTypes())
            //dispatch(postTypesReceived(response.data.return));
        })
        .then(function (error) {
            if (error) {
                console.log(error);
            }
        });
    } 
}