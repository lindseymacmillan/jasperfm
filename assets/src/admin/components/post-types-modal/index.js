import { useSelector, useDispatch } from 'react-redux'
import { closePostTypesModal, deletePostType } from '../../screens/distribution/redux/actions/postTypesActions'
const { Button, Modal } = wp.components
const { Fragment } = wp.element
import PostTypeFields from '../post-type-fields'
import PostTypeSettings from '../post-type-settings'
import NewPostType from '../post-type-new'

import styles from './style.css'

const PostTypesModal = () => {

    const isOpen = useSelector(state => state.postTypes.modal.is_open)
    const mode = useSelector(state => state.postTypes.modal.mode)
    const postTypeName = useSelector(state => state.postTypes.modal.post_type)
    const postType = useSelector(state => state.postTypes.post_types[postTypeName])
    const dispatch = useDispatch()

    const SwitchModal = () => {
        switch (mode) {
            case 'new':
                return (
                    <Modal
                        title="New post type"
                        onRequestClose={ () => dispatch(closePostTypesModal()) }>
                        <NewPostType />
                    </Modal>
                )
                break;
            case 'settings':
                return (
                    <Modal
                        title={'Edit ' + postType.labels.singular_name.toLowerCase() + ' type settings'}
                        onRequestClose={ () => dispatch(closePostTypesModal()) }>
                        <PostTypeSettings />
                    </Modal>
                )
                break;
            case 'fields':
                return (
                    <Modal
                        className={styles.fieldsmodal}
                        title={'Edit ' + postType.labels.singular_name.toLowerCase() + ' type fields'}
                        onRequestClose={ () => dispatch(closePostTypesModal()) }>
                        <PostTypeFields />
                    </Modal>
                )
                break;
            case 'delete':
                return (
                    <Modal
                        title={'Delete ' + postType.labels.singular_name.toLowerCase() + ' type'}
                        onRequestClose={ () => dispatch(closePostTypesModal()) }>
                        <Button isPrimary onClick={ () => dispatch(deletePostType(postTypeName)) }>
                            Delete
                        </Button>
                    </Modal>
                )
                break;
            default: 
                return (
                    <Modal
                        title="No action specified."
                        onRequestClose={ () => dispatch(closePostTypesModal()) }>
                        <Button isDefault onClick={ () => dispatch(closePostTypesModal()) }>
                            Error
                        </Button>
                    </Modal>
                )
        }
    }

    return (
        <Fragment>
            {isOpen && (
                <SwitchModal />
            )}
        </Fragment>
    )
}

export default PostTypesModal;